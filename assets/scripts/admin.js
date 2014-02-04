;(function(){

	if($(".design").length > 0) {
		$(".design").select2();
	}
	
	var config = {
		baseUrl : window.location.protocol+"//"+window.location.host+'/survey',
		counter : 1,
		doc     : $(document)
	}
	
	var questionConf = {
		trigger : 'button.add-question',
		remove  : 'span.remove-question',
		add     : 'input.survey-interface',
		status  : 0,
	}
	
	var questionFunc = {
		addQuestion : function() {
			return this.delegate(questionConf.trigger, 'click', function (e) {
				e.preventDefault();
				config.counter = config.counter+1;
				$('.survey .form-group:last')
				.after('<div class="form-group input-group this-remove-' + config.counter + '">'+
				'<input type="text" name="questions[]" class="form-control" autocomplete="off" placeholder="Answer #' + config.counter + '"> '+
				'<span data-remove="' + config.counter + '" class="input-group-addon remove-question">'+
				'<a href="javascript: void(0);">Remove</a></span>'+
				'</div>');
			});
		},
		
		removeQuestion : function() {
			return this.delegate(questionConf.remove, 'click', function () {
				removal = $(this).data('remove');
				$('div.this-remove-'+removal).remove();
			});
		},
		
		showSurvey : function() {
			return this.delegate(questionConf.add, 'click', function () {
				if(questionConf.status == 0) {
					$('div.survey').show();
					questionConf.status = 1;
					$(this).val(1);
				} else {
					$('div.survey').hide();
					questionConf.status = 0;
					$(this).val(0);
				}
			});
		}
	}
	
	$.extend(config.doc, questionFunc);
	config.doc.removeQuestion();
	config.doc.addQuestion();
	config.doc.showSurvey();
	
	var studentNumberConf = {
		department  : "select.department-pick"
	}
	
	var studentNumberFunc = {
		getStudenNumber : function() {
			return this.delegate(studentNumberConf.department, 'change', function () {
				department_id = $(this).val();
				// console.log(department_id); return false;
				jQuery.ajax({
					type: "POST",
					url: config.baseUrl+"/studentnumber/get_student_no/",
					data: { 'department_id' : department_id },
					cache: false,
					success: function (response) {
						$('select#student_id_edit').empty().html(response);
					}, error: function () {
						console.log('Something went wrong..');
					}
				});
			});
		}
	}
	$.extend(config.doc, studentNumberFunc);
	config.doc.getStudenNumber();
	
	
	var studentsConf = {
		student_id : ".department-id",
		banunban   : ".banunban"
	}
	
	var studentsFunc = {
		getStudent : function() {
			return this.delegate(studentsConf.student_id, 'change', function () {
				department_id = $(this).val();
				action = $(this).data("action");

				jQuery.ajax({
					type: "POST",
					url: config.baseUrl+"/ban/get_students/",
					data: { 'department_id' : department_id, 'action' : action },
					cache: false,
					success: function (response) {
						$('select#student_id'+action).html(response);
					}, error: function () {
						console.log('Something went wrong..');
					}
				});
			});
		},
		BanFunc : function() {
			return this.delegate(studentsConf.banunban, 'click', function () {
				action = $(this).data("action");
				forms = $(this).parent().serialize()+ '&action=' + action;

				jQuery.ajax({
					type: "POST",
					url: config.baseUrl+"/ban/process/",
					data: forms,
					cache: false,
					success: function (response) {
						if(response == "less") {
							alert("Unban date should not be less than the date today.");
							return false;
						}
						if(response == "equal") {
							alert("Unban date should not be equal than the date today.");
							return false;
						}
						
						$(".design").select2("val", "");
						$('select#student_id'+action).html(response);
						if(action == 1) {
							alert('Banned success!');
						} else {
							alert('Unbanned success!');
						}
					}, error: function () {
						console.log('Something went wrong..');
					}
				});
			});
		}
	}

	$.extend(config.doc, studentsFunc);
	config.doc.getStudent();
	config.doc.BanFunc();
	
	var editUserConf = {
		select: ".edit-user"
	}
	
	
	var editUserFunc = {
		show: function(){
			return this.delegate(editUserConf.select, 'change', function () {
				var me = $(this), department_id = me.val();
				if(department_id == "") return false;
				jQuery.ajax({
					type: "POST",
					url: config.baseUrl+"/admin/user_list/",
					data: {'department_id': department_id},
					cache: false,
					success: function (response) {
						$("div.users-list").html(response);
					}, error: function () {
						console.log('Something went wrong..');
					}
				});
			})
		}
	}
	$.extend(config.doc, editUserFunc);
	config.doc.show();
	
}(jQuery, window, document));
