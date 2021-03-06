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
		only    : '.only-survey',
		status  : 0,
		status_2: 0,
		store_activity: '.store-activity',
		store_activity2: '.storage'
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
		},
		onlySurvey: function() {
			return this.delegate(questionConf.only, 'click', function () {
				if(questionConf.status_2 == 0) {
					$('div.survey').show();
					questionConf.status_2 = 1;
					$(this).val(1);
					if(questionConf.status == 0) {
						$(questionConf.add).trigger( "click" );
					}
				} else {
					$('div.survey').hide();
					questionConf.status_2 = 0;
					$(this).val(0);
					if(questionConf.status == 1) {
						$(questionConf.add).trigger( "click" );
					}
				}

				$('div.form-activity').slideToggle();
			});
		},
		store_activity : function() {
			return this.delegate(questionConf.store_activity, 'submit', function(e){
				var survey_title = $("input[name=survey_title]").val();
				if(questionConf.status == 1 && survey_title == "") {
					e.stopPropagation();
					e.preventDefault();
					alert("Please enter survey title.");
				}
			});
		},
		store_activity2 : function() {
			return this.delegate(questionConf.store_activity2, 'click', function(e){
				var survey_title = $("input[name=survey_title]").val();
				if(questionConf.status == 1 && survey_title == "") {
					e.stopPropagation();
					e.preventDefault();
					alert("Please enter survey title.");
				}
			});
		},
	}
	
	$.extend(config.doc, questionFunc);
	config.doc.store_activity2();
	config.doc.store_activity();
	config.doc.removeQuestion();
	config.doc.addQuestion();
	config.doc.showSurvey();
	config.doc.onlySurvey();
	
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
		showUsers: function(){
			return this.delegate(editUserConf.select, 'change', function () {
				var me = $(this), department_id = me.val();
				var user_name = $("input[name=username]").val();
				config.doc.userProcess(department_id, user_name);
			})
		},
		enterUsers: function() {
			return this.delegate("input[name=username]", 'keyup', function (e) {
				if(e.keyCode != 13) return false;
				var me = $(this), department_id = $(editUserConf.select).val();
				var user_name = $("input[name=username]").val();
				config.doc.userProcess(department_id, user_name);
			})
		},
		userProcess: function(department_id, user_name) {
			jQuery.ajax({
				type: "POST",
				url: config.baseUrl+"/admin/user_list/",
				data: {'department_id': department_id, 'user_name': user_name},
				cache: false,
				success: function (response) {
					$("div.users-list").html(response);
				}, error: function () {
					console.log('Something went wrong..');
				}
			});
		}
	}
	$.extend(config.doc, editUserFunc);
	config.doc.showUsers();
	config.doc.enterUsers();
	
}(jQuery, window, document));
