
<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script type="text/javascript">
    window.processingHTML_Datatable = '<span class="spinner-border spinner-border-reverse align-self-center loader-lg text-success"></span>';
</script>
<!-- jQuery -->
<script src="{{ asset('admin_assets/assets/js/jquery-3.5.1.min.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('admin_assets/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('admin_assets/assets/js/bootstrap.min.js') }}"></script>

<!-- Feather Icon JS -->
<script src="{{ asset('admin_assets/assets/js/feather.min.js') }}"></script>

<!-- Slimscroll JS -->
<script src="{{ asset('admin_assets/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('admin_assets/assets/plugins/sweetalerts/sweetalert2.min.js')}}"></script>
<script src="{{ asset('admin_assets/assets/plugins/sweetalerts/custom-sweetalert.js')}}"></script>



<script src="{{ asset('admin_assets/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_assets/assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('admin_assets/assets/js/select2.min.js')}}"></script>
<script src="{{ asset('admin_assets/assets/js/moment.min.js')}}"></script>

<!-- Custom JS -->
<script src="{{ asset('admin_assets/assets/js/script.js') }}"></script>
<script src="{{ asset('admin_assets/assets/js/bootstrap-datepicker.min.js')}}"></script> 

<!-- END GLOBAL MANDATORY SCRIPTS -->

<!----Add here global Js ----start----->
<script type="text/javascript" >
const toast = swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
					padding: '2em'
  			});

function showSweetAlert(text1='Completed',text2='Successfully Done', alerttype='1'){
		if(0==alerttype){  alerttype ="error";  } else if(1==alerttype) { alerttype ="success";  } else { alerttype ="question";  }
		swal(text1,text2,alerttype);
}

function isEmail(emailidgiven='') {
	 var regexemail = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(emailidgiven==''){  return true; }
	else
	{
  		return regexemail.test(emailidgiven);
	}
}

function randomIntFromInterval(min, max) { 
  return Math.floor(Math.random() * (max - min + 1) + min);
}
function makeid(length,ifnumberonly=0) {
   var result           = '';
   if(ifnumberonly==0){
   var characters  = 'abcdefghijklmVCXZQUIOP1234506789@$#!&-=:][{}KLnopqrstuvwxyzASDFGHJMNBWERTY';
   }
   else
   {
	    var characters = '123456789';
   }
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return  result;
}




</script>