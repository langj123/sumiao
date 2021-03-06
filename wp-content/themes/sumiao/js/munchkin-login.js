var _mkto_trk = jQuery.cookie('_mkto_trk');
var mkt_usr;
var field = "firstName,company,email,lastName,Job_Role__c,State,Marketing_Automation_Solution__c,Main_Pain_Points__c,Country,optionalPhone,Timeframe_to_Purchase__c,Revenue_Range__c,Time_Zone__c,Phone,Best_Time_to_Call__c,formCount,Unsubscribed";

MktoForms2.loadForm("http://app-ab16.marketo.com", "118-LCQ-066", 3, function (form) {
    jQuery.get("/ANN-MarketoRestApi.php", { mkto_cookie: _mkto_trk, fields: field }).done(function (data) {
        //console.log("data: " + data);
        var mkt_obj = jQuery.parseJSON(data);
        var status = mkt_obj.success;
        if (jQuery.trim(status) == "true") {
            var mkt_array = mkt_obj.result;
            mkt_usr = mkt_array[0];
        }

        if (mkt_usr != undefined) {
            form.vals({
                "FirstName": mkt_usr.firstName,
                "LastName": mkt_usr.lastName,
                "Email": mkt_usr.email,
				"Company": mkt_usr.company,
				"Job_Role__c": mkt_usr.Job_Role__c,
				"Marketing_Automation_Solution__c": mkt_usr.Marketing_Automation_Solution__c,
				"Main_Pain_Points__c": mkt_usr.Main_Pain_Points__c,
				"Country": mkt_usr.Country,
				"optionalPhone": mkt_usr.optionalPhone,
				"Timeframe_to_Purchase__c": mkt_usr.Timeframe_to_Purchase__c,
				"Revenue_Range__c": mkt_usr.Revenue_Range__c,
				"State": mkt_usr.state,
				"Phone": mkt_usr.phone,
				"Best_Time_to_Call__c": mkt_usr.Best_Time_to_Call__c,
				"Time_Zone__c": mkt_usr.Time_Zone__c,
				"formCount": mkt_usr.formCount,
				"Unsubscribed": mkt_usr.unsubscribed
            });
			//alert(mkt_usr.formCount);
        }

    });
});