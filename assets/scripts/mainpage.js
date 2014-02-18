;(function(){
	var config = {
		baseUrl : window.location.protocol+"//"+window.location.host+'/survey',
		doc     : $(document)
	}
	
	var answerConf = {
		trigger : '.question-trigger',
		edit    : '.edit-answer'
	}
	
	var answerFunc = {
		focusFunc : function() {
			return this.delegate(answerConf.trigger, 'click', function(){
				// $(this).find('input[type=text]').focus();
			})
		},
		editFunc : function() {
			return this.delegate(answerConf.edit, "keyup", function(e){
				return false;
				if(e.keyCode != 13) return false;

				me = $(this),
				value = me.val(),
				entry = me.data("entry");
				
				jQuery.ajax({
					type: "POST",
					url: config.baseUrl+"/survey/survey_question/",
					data: { 'survey_question' : value, 'question_id' : entry },
					cache: false,
					success: function (response) {
						me.val(value);
						alert('Successfully updated.');
					}, error: function () {
						console.log('Something went wrong..');
					}
				});
			})
		}
	}

	$.extend(config.doc, answerFunc);
	config.doc.focusFunc();
	config.doc.editFunc();
	
	var tabMainConf = {
		tab   : '.mainpage ul.nav-justified li',
		admin : '#department_id'
	}
	
	var tabMainFunc = {
		switchTab : function() {
			return this.delegate(tabMainConf.tab, 'click', function(){
				if($(this).hasClass("active")) return false;
				
				$(tabMainConf.tab).each(function() {
					$(tabMainConf.tab).removeClass("active");
				});
				
				$(this).addClass("active");
				tab_id = $(this).data('tab-id');

				jQuery.ajax({
					type: "POST",
					url: config.baseUrl+"/main/switch_tab/",
					data: { 'tab_id' : tab_id },
					cache: false,
					success: function (response) {
						$('ul.category').html(response);
					}, error: function () {
						console.log('Something went wrong..');
					}
				});
			});
		},
		adminTab : function() {
			return this.delegate(tabMainConf.admin, 'change', function(){
				me = $(this),
				tab_id = me.val();
				jQuery.ajax({
					type: "POST",
					url: config.baseUrl+"/main/switch_tab/",
					data: { 'tab_id' : tab_id },
					cache: false,
					success: function (response) {
						$('ul.category').html(response);
						me.css("margin-bottom", "10px");
					}, error: function () {
						console.log('Something went wrong..');
					}
				});
			});
		}
	}
	
	$.extend(config.doc, tabMainFunc);
	config.doc.switchTab();
	config.doc.adminTab();
	
	var voteSurveyConf = {
		delete_act  : 'li.delete-activity',
		delete_surv : 'li.delete-survey',
		choice      : 'input.question-pick',
		comment     : 'input.comment-bar',
		delete_comm : 'a.delete_comment',
		edit_comm   : 'a.edit_comment',
		edit_face   : 'input.edit-comment-edit',
		image_remove: 'span.remove-image',
		is_edit     : 0,
		propagation : 0
	}
	
	var voteSurveyFunc = {
		activityDelete : function() {
			return this.delegate(voteSurveyConf.delete_act, 'click', function(){
				activity_id = $(this).data('activity-id');
				
				if(confirm('Are you sure you want to delete this activity?')) {
					location.href=config.baseUrl+"/activity/activity_delete/"+activity_id;
				}
			});
		},
		
		surveyDelete : function() {
			return this.delegate(voteSurveyConf.delete_surv, 'click', function(){
				survey_id = $(this).data('survey-id');
				console.log(survey_id);
				
				if(confirm('Are you sure you want to delete this survey?')) {
					location.href=config.baseUrl+"/survey/survey_delete/"+survey_id;
				}
			});
		},

		votingAdd : function(){
			return this.delegate(voteSurveyConf.choice, 'click', function(e){
				$('#the_choice').attr('checked', false);
			    checked = $(this).data('checked');
				if(checked == 1) {
					$('li.warning-message').html('<p class="alert alert-danger">You\'re not allowed to choose the same answer.</p>').addClass('list-group-item');
					return false;
				}
				
				if(voteSurveyConf.propagation === 0) {
					voteSurveyConf.propagation = 1;
				} else {
					$('li.warning-message').html('<p class="alert alert-danger">Please wait while your previous vote is still processing..</p>');
					return false;
				}
				
				choice_num  = $(this).data('count');
				question_id = $(this).data('question-id');
				survey_id   = $(this).data('survey-id');
				activity_id = $(this).data('activity-id');

				if( confirm('Are you sure you want to vote for choice '+choice_num+'?') ) {
					jQuery.ajax({
						type: "POST",
						url: config.baseUrl+"/activity/choosen/",
						data: { 'question_id' : question_id, 'survey_id' : survey_id, 'activity_id' : activity_id },
						cache: false,
						success: function (response) {
							$('div#survey-container').html(response);
							voteSurveyConf.propagation = 0;
						}, error: function () {
							console.log('Something went wrong..');
						}
					});
				} else {
					e.preventDefault();
					e.stopPropagation();
					$(this).attr('checked', false);
					$('#the_choice').attr('checked', true);
					voteSurveyConf.propagation = 0;
				}
			});
		},

		commentAdd : function(){
			return this.delegate(voteSurveyConf.comment, "keyup", function(e){
				if (e.keyCode != 13) return false;
				comment     = $(this).val();
				activity_id = $(this).data('activity-id');

					jQuery.ajax({
						type: "POST",
						url: config.baseUrl+"/activity/comment/",
						data: { 'comment' : comment, 'activity_id' : activity_id },
						cache: false,
						success: function (response) {
							$('span.comment-badge').after(response);
							$(voteSurveyConf.comment).val('');
						}, error: function () {
							console.log('Something went wrong..');
						}
					});
			});
		},
		
		commentDel : function() {
			return this.delegate(voteSurveyConf.delete_comm, 'click', function(e){
				if(confirm('Are you sure you want to delete this comment?')) {
					comment_id = $(this).data('id');
					jQuery.ajax({
						type: "POST",
						url: config.baseUrl+"/activity/commentDel/",
						data: { 'comment_id' : comment_id },
						cache: false,
						success: function (response) {
							$('.wrapper-comment-'+comment_id).slideToggle();
						}, error: function () {
							console.log('Something went wrong..');
						}
					});
				}
			});
		},
		
		commentEdit : function() {
			return this.delegate(voteSurveyConf.edit_comm, 'click', function(e){
				comment_id = $(this).data('id');
				if(voteSurveyConf.is_edit == 0) {
					$('.edit-show-'+comment_id).show();
					$('.comment-face-'+comment_id).hide();
					voteSurveyConf.is_edit = 1;
					$(this).text('Cancel');
				} else {
					$('.edit-show-'+comment_id).hide();
					$('.comment-face-'+comment_id).show();
					voteSurveyConf.is_edit = 0;
					$(this).text('Edit');
				}	
			});
		},
		
		commentUpdate : function() {
			return this.delegate(voteSurveyConf.edit_face, "keyup", function(e){
				if (e.keyCode != 13) return false;
				newComment = $(this).val();
				comment_id = $(this).data('id');
				me = $(this);
				jQuery.ajax({
					type: "POST",
					url: config.baseUrl+"/activity/commentUpdate/",
					data: { 'comment' : newComment, 'comment_id' : comment_id },
					cache: false,
					success: function (response) {
						// $('.wrapper-comment-'+comment_id).slideToggle();
						$('.edit-show-'+comment_id).hide();
						$('.comment-face-'+comment_id).show();
						voteSurveyConf.is_edit = 0;
						$('.edit-comment-'+comment_id).text('Edit');
						me.val('');
						
						$('.comment-face-'+comment_id).text(newComment);
					}, error: function () {
						console.log('Something went wrong..');
					}
				});
			});
		},
		
		imageDelete : function() {
			return this.delegate(voteSurveyConf.image_remove, "click", function(){
				me = $(this);
				image_id = me.data('image-id');
				
				if(confirm("Are you sure you want to delete this image?")) {
					jQuery.ajax({
						type: "POST",
						url: config.baseUrl+"/activity/image_delete/",
						data: { 'image_id' : image_id },
						cache: false,
						success: function (response) {
							me.parent().parent().fadeOut();
						}, error: function () {
							console.log('Something went wrong..');
						}
					});
				}
			});
		}
	}
	
	$.extend(config.doc, voteSurveyFunc);
	config.doc.activityDelete();
	config.doc.surveyDelete();
	config.doc.votingAdd();
	config.doc.commentAdd();
	config.doc.commentDel();
	config.doc.commentEdit();
	config.doc.commentUpdate();
	config.doc.imageDelete();

}(jQuery, window, document));