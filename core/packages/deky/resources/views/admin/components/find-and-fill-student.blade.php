@push('js_footer')
	<script type="text/javascript">
		$(function(){
			function setField(field, value) {
				var selector = '*[name="student['+ field +']"]';
				switch(field) {
					case 'birth':
						var studentBirth 	= value.split('-');
						var birthDay		= studentBirth[2];
						var birthMonth		= studentBirth[1];
						var birthYear		= studentBirth[0];
						$(selector).val(birthDay + '-' +  birthMonth + '-' + birthYear);
						break;

					default:
						$(selector).val(value);
						break;
				}
			};
			$('*[name="student[phone]"]').focusout(function(){
				var phone = $(this).val();
				if(phone != '') {
					$.ajax({
						url: '{{ api_url('v1/student') }}',
						type: 'get',
						dataType: 'json',
						data: {
							phone: phone
						},
						success: function(res) {
							$.each(res,  function(i, result) {
								$.each(result, function(field, value) {
									setField(field, value);
								});
							});
						},
					});
				}
			});
		});
	</script>
@endpush