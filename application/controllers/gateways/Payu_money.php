<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property-read Payu_money_gateway $payu_money_gateway
 */
class Payu_money extends App_Controller
{
    public function make_payment()
    {
        check_invoice_restrictions($this->input->get('invoiceid'), $this->input->get('hash'));

        $this->load->model('invoices_model');
        $invoice = $this->invoices_model->get($this->input->get('invoiceid'));

        load_client_language($invoice->clientid);

        $data['invoice'] = $invoice;
        $data['total']   = $this->session->userdata('payu_money_total');
        $data['key']     = $this->payu_money_gateway->getSetting('key');
        $data['attempt_reference']   = $this->session->userdata('attempt_reference') ?? '';
        $data['attempt_fee']   = $this->session->userdata('attempt_fee') ?? 0;
        $data['attempt_amount']   = $this->session->userdata('attempt_amount') ?? 0;

        $posted = [];

        if ($this->input->post()) {
            $data['action_url'] = $this->payu_money_gateway->get_action_url();
            foreach ($this->input->post() as $key => $value) {
                $posted[$key] = $value;
            }
            $data['txnid']       = $posted['txnid'];
            $data['firstname']   = $posted['firstname'];
            $data['lastname']    = $posted['lastname'];
            $data['email']       = $posted['email'];
            $data['phonenumber'] = $posted['phone'];
        } else {
            $data['txnid']      = $this->payu_money_gateway->gen_transaction_id();
            $data['action_url'] = $this->uri->uri_string() . '?invoiceid=' . $invoice->id . '&hash=' . $invoice->hash;

            $data['firstname']   = '';
            $data['lastname']    = '';
            $data['email']       = '';
            $data['phonenumber'] = '';

            if (is_client_logged_in()) {
                $contact = $this->clients_model->get_contact(get_contact_user_id());
            } else {
                if (total_rows(db_prefix() . 'contacts', ['userid' => $invoice->clientid]) == 1) {
                    $contact = $this->clients_model->get_contact(get_primary_contact_user_id($invoice->clientid));
                }
            }

            if (isset($contact) && $contact) {
                $data['firstname']   = $contact->firstname;
                $data['lastname']    = $contact->lastname;
                $data['email']       = $contact->email;
                $data['phonenumber'] = $contact->phonenumber;
            }
        }

        $data['hash'] = '';

        // there is post request
        if (count($posted) > 0) {
            $data['hash'] = $this->payu_money_gateway->get_hash([
                'key'         => $posted['key'],
                'txnid'       => $posted['txnid'],
                'amount'      => $posted['amount'],
                'productinfo' => $posted['productinfo'],
                'firstname'   => $posted['firstname'],
                'email'       => $posted['email'],
                'udf1'        => $data['attempt_reference']
                ]);
        }

        echo $this->get_html($data);
    }

    public function success()
    {
        $invoiceid = $this->input->get('invoiceid');
        $hash      = $this->input->get('hash');

        check_invoice_restrictions($invoiceid, $hash);
        $this->load->model('invoices_model');
        $invoice = $this->invoices_model->get($this->input->get('invoiceid'));
        load_client_language($invoice->clientid);

        $hashInfo = $this->payu_money_gateway->get_valid_hash($_POST);
        if (!$hashInfo) {
            set_alert('warning', _l('invalid_transaction'));
        } else {
            if ($hashInfo['status'] == 'success') {
                if (total_rows('invoicepaymentrecords', ['transactionid' => $hashInfo['txnid']]) === 0) {
                    $success = $this->payu_money_gateway->addPayment([
                    'amount'        => $hashInfo['amount'],
                    'invoiceid'     => $invoiceid,
                    'transactionid' => $hashInfo['txnid'],
                    'paymentmethod' => $hashInfo['transaction_mode'],
                    'payment_attempt_reference' => $hashInfo['attempt_reference'],
                    ]);
                    if ($success) {
                        set_alert('success', _l('online_payment_recorded_success'));
                    } else {
                        set_alert('danger', _l('online_payment_recorded_success_fail_database'));
                    }
                }
            } else {
                if ($this->payu_money_gateway->getSetting('test_mode_enabled') == '1') {
                    log_activity('Payu Money Transaction Not With Status Success: ' . var_export($_POST, true));
                }
                set_alert('warning', 'Thank You. Your transaction status is ' . $hashInfo['status']);
            }
        }
        $this->session->unset_userdata('payu_money_total');
        redirect(site_url('invoice/' . $invoiceid . '/' . $hash));
    }

    public function failure()
    {
        $invoiceid = $this->input->get('invoiceid');
        $hash      = $this->input->get('hash');

        check_invoice_restrictions($invoiceid, $hash);
        $this->load->model('invoices_model');
        $invoice = $this->invoices_model->get($this->input->get('invoiceid'));
        load_client_language($invoice->clientid);

        $hashInfo = $this->payu_money_gateway->get_valid_hash($_POST);

        if (!$hashInfo) {
            set_alert('warning', _l('invalid_transaction'));
        } else {
            if ($hashInfo['unmappedstatus'] != 'userCancelled') {
                set_alert('warning', $hashInfo['error_Message'] . ' - ' . $hashInfo['status']);
            }
        }

        $this->session->unset_userdata('payu_money_total');

        redirect(site_url('invoice/' . $invoiceid . '/' . $hash));
    }

    public function get_html($data)
    {
        ob_start(); ?>
<?php echo payment_gateway_head(_l('payment_for_invoice') . ' ' . format_invoice_number($data['invoice']->id)); ?>

<body onload="submitPayuForm()" class="gateway-payu-money">
    <div class="container">
        <div class="col-md-8 col-md-offset-2 mtop30">
            <div class="mbot30 text-center">
                <?php echo payment_gateway_logo(); ?>
            </div>
            <div class="row">
                <?php echo form_open($data['action_url'], ['novalidate' => true, 'id' => 'payu_money_form']); ?>
                <div class="panel_s">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <?php echo _l('payment_for_invoice'); ?> -
                            <?php echo e(_l('payment_total', app_format_money($data['total'], $data['invoice']->currency_name))); ?>
                        </h4>
                        <a
                            href="<?php echo site_url('invoice/' . $data['invoice']->id . '/' . $data['invoice']->hash); ?>">
                            <?php echo e(format_invoice_number($data['invoice']->id)); ?>
                        </a>
                    </div>
                    <div class="panel-body">
                        <?php if ($this->payu_money_gateway->processingFees) { ?>
                            <h4><?php echo _l('payment_attempt_amount') . ": " . e(app_format_money($data['attempt_amount'], $data['invoice']->currency_name)); ?></h4>
                            <h4><?php echo _l('payment_attempt_fee') . ": " . e(app_format_money($data['attempt_fee'], $data['invoice']->currency_name)); ?></h4>
                        <?php } ?>
                        <hr />
                        <input type="hidden" name="key" value="<?php echo $data['key'] ?>" />
                        <input type="hidden" name="hash" value="<?php echo $data['hash'] ?>" />
                        <input type="hidden" name="txnid" value="<?php echo $data['txnid'] ?>" />
                        <input type="hidden" name="amount" value="<?php echo $data['total'] ?>" />
                        <input type="hidden" name="udf1" value="<?php echo $data['attempt_reference'] ?>" />
                        <input type="hidden" name="surl"
                            value="<?php echo site_url('gateways/payu_money/success?invoiceid=' . $data['invoice']->id . '&hash=' . $data['invoice']->hash); ?>" />
                        <input type="hidden" name="furl"
                            value="<?php echo site_url('gateways/payu_money/failure?invoiceid=' . $data['invoice']->id . '&hash=' . $data['invoice']->hash); ?>" />
                        <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
                        <input type="hidden" name="productinfo"
                            value="<?php echo e(str_replace('{invoice_number}', format_invoice_number($data['invoice']->id), $this->payu_money_gateway->getSetting('description_dashboard'))); ?>" />
                        <div class="form-group">
                            <label for="first_name"> <?php echo _l('client_firstname'); ?></label>
                            <input type="text" class="form-control" id="first_name" name="firstname"
                                value="<?php echo e($data['firstname']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name"> <?php echo _l('client_lastname'); ?></label>
                            <input type="text" class="form-control" id="last_name" name="lastname"
                                value="<?php echo e($data['lastname']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="email"> <?php echo _l('client_email'); ?> </label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?php echo e($data['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phone"> <?php echo _l('client_phonenumber'); ?></label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="<?php echo e($data['phonenumber']); ?>" required>
                        </div>
                    </div>
                    <?php if (!$data['hash']) { ?>
                    <div class="panel-footer text-right">
                        <input type="submit" class="btn btn-primary" value="<?php echo _l('submit_payment'); ?>" />
                    </div>
                    <?php } ?>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <?php echo payment_gateway_scripts(); ?>
    <script>
    $(function() {
        $('#payu_money_form').validate({
            submitHandler: function(form) {
                $('input[type="submit"]').prop('disabled', true);
                return true;
            }
        });
    });
    var hash = '<?php echo $data['hash']; ?>';

    function submitPayuForm() {
        if (hash == '') {
            return;
        }
        var payu_money_form = document.forms.payu_money_form;
        payu_money_form.submit();
    }
    </script>
    <?php echo payment_gateway_footer(); ?>
    <?php
        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
    }
}
