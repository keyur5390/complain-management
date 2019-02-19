<div class="individual formBox" >
    
            <!-- <label for="txtLabel" class="form-label span2">Send To: em>*</em</label> -->
            <div class="Mail-Main">
                <select multiple name="selSendTo[]" id="selSendTo" title="Select Customer Email" class="span10 nostyle uniquesendmail" >
                    <option value="">Select Customer Email</option>
                </select>
                <label class="text-error" for="selSendTo" generated="true" style="display: none;padding-left: 14.5299%;">Please select email address</label>
                <input type="hidden" name="hascustomer" id="hascustomer" value="">
            </div>
<!--            <div>
              <label>
                <input title="Send to all customer" type="checkbox" name="send_to_all" value="1" id="send_to_all">Send to all customer
              </label>
              
            </div>-->
            <div class="optionBox">
<!--                <div class="chkInn">
                    <label>
                        <input type="checkbox" class="checkbox">
                        <input type="checkbox" class="checkbox" id="send_to_all" name="send_to_all" value="1" title="Send to all customer" data-content="Send to all customer">
                        <span>Send to all customer</span>
                    </label>
                </div>                                                   -->
            </div>

        
            <div class="" id="other_emails" style="display:none;">

                <div class="newInputMain Open-mailbox" style="margin-bottom: 25px;    margin-top: -60px;">
                        <!-- <label for="txtLabel" class="form-label span2">Email: em>*</em</label> -->

                        <input title="Other email address" type="text" name="txtOther" id="txtOther" class="validSendTo txt uniquesendmail" value="" placeholder="Other email address"/>
                        <label class="dark-red" style="float:left;color: grey;">Use comma(,) to separate multiple emails. e.g. info@abc.com, sales@abc.com</label><br>
                        <input type="hidden" name="customer_id_hide" id="customer_id_hide" value="" />
                    </div>

            </div>
</div>

<!--<div class="" style="clear:both; display:none">
    
             <label for="txtCCLabel" class="form-label span2">CC :</label> 
            <div class="newInputMain Mail-Main">
                <select title="CC email address" name="selSendCC" id="selSendCC" class="span10 nostyle uniquesendmail">
                    <option value="">Select CC Customer Email</option>
                </select>
                
            </div>
        <div class="" id="other_emails_cc" style="display:none;">
        
            <div class="newInputMain Open-mailbox">
                 <label for="txtOtherCC" class="form-label span2">CC Email: </label> 
                <input title="Other CC email address" type="text" name="txtOtherCC" id="txtOtherCC" class="txt validSendTo uniquesendmail" value="" placeholder="Other CC email address"/><br>
                <label class="dark-red" style="float:left;color: grey;">Use comma(,) to separate multiple emails. e.g. info@abc.com, sales@abc.com</label><br>
            </div>
        
    </div>
</div>-->
<script type="text/javascript">
    $(document).ready(function(){
      load_customer_select();
    });
   function load_customer_select() {
        var selected_cust_ids = '';
        var selectors = $("#selSendTo");
        var get_url = "<?php echo CFG::$livePath; ?>/page.php";
        
        selectors.select2({
            minimumInputLength: 1,
            width: "100%",
            placeholder: "Search customer name",
            ajax: {
                url: get_url,
                dataType: 'json',
                data: function (params) {
                  return {
                    code: params.term,
                    notid :selected_cust_ids,
                    action:'all_customer_email'// search term
                  };
                },
                processResults: function (data, params) {

                  params.page = params.page || 1;

                  return {
                    results: data.items,
                  };
                },
                cache: false
              },
        });
        selectors.on("select2:select", function(e) {
          $('#hascustomer').val('1');
        });
        

    }
</script>
<?php //require CFG::$absPath . '/helper/templates/tpl_sales_send_mail_cc_drop_down.php';?>


