var ControlPanel = (function() {
    
    var contacts;
    
    function pageArray(currentPage, countPages) {
        if (countPages == 0 || countPages == 1) return [];
        var pageArr = [];
        if (countPages > 10) {
    		if(currentPage <= 4 || currentPage + 3 >= countPages) {
    			for(var i = 0; i <= 4; i++) {
    				pageArr[i] = i + 1;
    			}
    			pageArr[5] = "...";
    			for(var j = 6, k = 4; j <= 10; j++, k--) {
    				pageArr[j] = countPages - k;
    			}			
    		} else {
    			pageArr[0] = 1;
    			pageArr[1] = 2;
    			pageArr[2] = "...";
    			pageArr[3] = currentPage - 2;
    			pageArr[4] = currentPage - 1;
    			pageArr[5] = currentPage;
    			pageArr[6] = currentPage + 1;
    			pageArr[7] = currentPage + 2;
    			pageArr[8] = "...";
    			pageArr[9] = countPages - 1;
    			pageArr[10] = countPages;
    		}
    	} else {
    		for(var n = 0; n < countPages; n++) {
    			pageArr[n] = n + 1;
    		}
    	}
    	return pageArr;
    }
    
    function printPagination(currentPage, countPages, funcName) {
        var pageArr = pageArray(currentPage, countPages);
        $("#pagination").html('');
        if(Object.keys(pageArr).length > 0) {
            var html = '<div class="btn-group">';
            $.each(pageArr, function(key, val) {
                if(val == '...') {
                    html += '</div><div class="btn-group">';
                } else if(currentPage == val) {
                    html += '<span class="active btn btn-default">'+val+'</span>';
                } else {
                    html += '<a class="btn btn-default" onClick="'+funcName+'(\''+val+'\');">'+val+'</a>';
                }
            });
            html += '</div>';
            $("#pagination").html(html);
        }
    }
    
    return {
        emailConfirmation: function() {
            $(".confirmEmail").html('Необходимо подтвердить адрес эл.почты');
            $.ajax({
                url: "/activate-email/", 
                method: "POST",
                data: {'ajax':'','sendConfirm':''},
                success : function(data, status, request) {
                    if(request.getResponseHeader('location') != null) {
                        window.location.href = request.getResponseHeader('location');
                    }
                    try {
                        if((data.length > 0) && JSON.parse(data)[0]) {
                            $("#infoPanel").html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>На указанный Вами e-mail отправлено письмо.<br>Пожалуйста, перейдите по ссылке из письма для подтверждения адреса эл.почты.</div>');
                        } else {
                            throw '';
                        }
                    } catch (e) {
                        $(".confirmEmail").html('Необходимо <a onClick="ControlPanel.emailConfirmation();" data-placement="right" title="Подтвердить адрес эл.почты">подтвердить</a> адрес эл.почты');
                    }
                }
            });
        },
        saveUserInfo: function() {
            try {
                if(($("#password").val().length > 0) && ($("#password").val().length < 6)) {
                    throw ('Длина пароля, должна быть не менее 6 символов');
                }
                if($("#confirmedPassword").val() != $("#password").val()) throw 'Пароли различаются!';
                $("#saveMyInfo").button('loading');
                $.ajax({
                    url: "/save-user-info/",
                    method: "POST",
                    data: {
                        'ajax':'',
                        'user-id':$("#userId").val(),
                        'group-ip':$("#listAllGroups").val(),
                        'first-name':$("#firstName").val(),
                        'last-name':$("#lastName").val(),
                        'phone-number':$("#phoneNumber").val(),
                        'second-phone-number':$("#secondPhoneNumber").val(),
                        'skype':$("#skype").val(),
                        'email':$("#email").val(),
                        'site':$("#site").val(),
                        'password':$("#password").val()
                    },
                    success: function(data, status, request) {
                        if(request.getResponseHeader('location') != null) {
                            window.location.href = request.getResponseHeader('location');
                        }
                        try {
                            var result = JSON.parse(data);
                            if(result[0] == true) {
                                $("#saveMyInfo").removeClass("btn-info");
                                $("#saveMyInfo").addClass("btn-success");
                                throw 'Данные успешно сохранены';
                            } else if(result['error'] != undefined) {
                                throw result['error'];
                            }
                        } catch (e) {
                            $("#infoPanel").html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+e+'</div>');
                        }
                    },
                    complete: function() {
                        $("#saveMyInfo").button('reset');
                    }
                });
            } catch (e) {
                $("#infoPanel").html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+e+'</div>');
            }
        },
        fetchAllUsers: function(page) {
            if(page == undefined) {
                page = 1;
            }
            $.ajax({
                url: "/list-all-users/",
                method: "POST",
                data: {
                    'ajax':'',
                    'currentPage':page
                },
                success: function(data, status, request) {
                    if(request.getResponseHeader('location') != null) {
                        window.location.href = request.getResponseHeader('location');
                    }
                    try {
                        var result = JSON.parse(data);
                        if(result['error'] == undefined) {
                            var html = '<table class="table table-striped"><thead><tr><th>#</th><th>Имя</th>';
                            html += '<th>Фамилия</th><th>Адрес эл.почты</th><th>Телефон</th><th>Дата последнего визита</th><th>Проекты</th><th>Аккаунт</th></tr></thead><tbody>';
                            $.each(result['users'], function(key, val) {
                                html += '<tr><td>'+((page-1)*10+key+1)+'</td>';
                                html += '<td>'+val['firstName']+'</td>';
                                html += '<td>'+val['lastName']+'</td>';
                                html += '<td>'+val['email']+'</td>';
                                html += '<td>'+val['mobilePhone']+'</td>';
                                html += '<td>'+val['dateLastEntry']+'</td>';
                                html += '<td><a onClick="ControlPanel.fetchAllProjects(\'1\',\''+val['userId']+'\');" href="#">Просмотреть</a></td>';
                                html += '<td><a href="/user-profile/'+val['userId']+'">Подробнее</a></td></tr>';
                            });
                            html += '</tbody></table><div id="pagination"></div>';
                            $("#mainContent").html(html);
                            printPagination(page, result['countPages'], 'ControlPanel.fetchAllUsers');
                        } else {
                            throw result['error'];
                        }
                    } catch (e) {
                        $("#infoPanel").html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+e+'</div>');
                    }
                },
                complete: function() {
                    
                }
            });
        },
        fetchContacts: function(page) {
            if(page == undefined) {
                page = 1;
            }
            $.ajax({
                url: "/fetch-contacts/",
                method: "POST",
                data: {
                    'ajax':'',
                    'currentPage':page
                },
                success: function(data, status, request) {
                    if(request.getResponseHeader('location') != null) {
                        window.location.href = request.getResponseHeader('location');
                    }
                    try {
                        contacts = JSON.parse(data);
                        if(contacts['error'] == undefined) {
                            var html = '<table class="table table-striped"><thead><tr><th>#</th><th>Страница</th><th>Имя</th>';
                            html += '<th>Телефон</th><th>Дата</th><th>Статус обработки</th><th></th></tr></thead><tbody>';
                            $.each(contacts['contacts'], function(key, val) {
                                html += '<tr><td>'+((page-1)*10+key+1)+'</td>';
                                html += '<td><a target="_blank" title="'+val['title']+'" href="'+val['url']+'">'+val['title']+'</a></td>';
                                html += '<td>'+val['customerName']+'</td>';
                                html += '<td>'+val['phoneNumber']+'</td>';
                                html += '<td>'+val['dateAdded']+'</td>';
                                html += '<td><div class="contPStatus checkbox checkbox-success">';
                                if(val['processingStatus']=='1') {
                                    html += '<input onChange="ControlPanel.questionSolved(\''+key+'\',\'#cb'+((page-1)*10+key+1)+'\');" id="cb'+((page-1)*10+key+1)+'" checked type="checkbox">';
                                } else {
                                    html += '<input onChange="ControlPanel.questionSolved(\''+key+'\',\'#cb'+((page-1)*10+key+1)+'\');" id="cb'+((page-1)*10+key+1)+'" type="checkbox">';
                                }
                                html += '<label for="cb'+((page-1)*10+key+1)+'"></label></div></td>';
                                html += '<td><a class="btn btn-info" onClick="ControlPanel.detailedInfo('+key+')">Подробнее</a></td>';
                            });
                            html += '</tbody></table><div id="pagination"></div>';
                            $("#mainContent").html(html);
                            printPagination(page, contacts['countPages'], 'ControlPanel.fetchContacts');
                        } else {
                            throw contacts['error'];
                        }
                    } catch (e) {
                        $("#infoPanel").html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+e+'</div>');
                    }
                },
                complete: function() {
                    
                }
            });
        },
        detailedInfo: function(id) {
            var html = '<table class="">';
            html += '<tr><th>Страница</th><td><a target="_blank" title="'+contacts.contacts[id]['title']+'" href="'+contacts.contacts[id]['url']+'">'+contacts.contacts[id]['title']+'</a></td></tr>';
            html += '<tr><th>Имя</th><td>'+contacts.contacts[id]['customerName']+'</td></tr>';
            html += '<tr><th>Телефон</th><td>'+contacts.contacts[id]['phoneNumber']+'</td></tr>';
            html += '<tr><th>Адрес эл.почты</th><td>'+contacts.contacts[id]['userEmail']+'</td></tr>';
            html += '<tr><th>Вопрос</th><td>'+contacts.contacts[id]['userQuestions']+'</td></tr>';
            html += '<tr><th>Дата</th><td>'+contacts.contacts[id]['dateAdded']+'</td></tr>';
            if(contacts.contacts[id]['processingStatus']=='0') {
                html += '<tr><th>Статус обработки</th><td>в ожидании</td></tr>';
            } else {
                html += '<tr><th>Статус обработки</th><td>завершен</td></tr>';
            }
            html += '</table>';
            $("#detailedInfo .modal-body").html(html);
            $('#detailedInfo').modal('show');
        },
        questionSolved: function(id, cbID) {
            if($(cbID).prop("checked")) {
                var cb = 1;
            } else {
                var cb = 0;
            }
            $.ajax({
                url: "/question-solved/",
                method: "POST",
                data: {
                    'ajax':'',
                    'contactID':contacts.contacts[id]['contactID'],
                    'ApiKeyID':contacts.contacts[id]['apiKeyId'],
                    'pStatus':cb
                },
                success: function(data, status, request) {
                    if(request.getResponseHeader('location') != null) {
                        window.location.href = request.getResponseHeader('location');
                    }
                    try {
                        var result = JSON.parse(data);
                        if(result['status'] != undefined) {
                            contacts.contacts[id]['processingStatus'] = cb;
                        }
                    } catch (e) {
                        $("#infoPanel").html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+e+'</div>');
                    }
                    
                }
            });
        },
        delProject: function(uID, pID, idElement) {
            if(confirm("Вы действительно хотите удалить проект?") && uID != undefined && pID != undefined) {
                $.ajax({
                    url: "/del-project/",
                    method: "POST",
                    data: {
                        'ajax':'',
                        'userID':uID,
                        'projectID':pID
                    },
                    success: function(data, status, request) {
                        if(request.getResponseHeader('location') != null) {
                            window.location.href = request.getResponseHeader('location');
                        }
                        try {
                            var result = JSON.parse(data);
                            if(result[0]) {
                                $("#"+idElement).remove();
                                throw result['message'];
                            } else {
                                throw result['message'];
                            }
                        } catch (e) {
                            $("#infoPanel").html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+e+'</div>');
                        }
                        
                    }
                });
            }
        },
        fetchAllProjects: function(page, uid) {
            if(page == undefined) {
                page = 1;
            }
            var request = {
                'ajax':'',
                'currentPage':page
            };
            if(uid != undefined) {
                request['user-id'] = uid;
            }
            $(".sub-header").html('Проекты');
            $.ajax({
                url: "/my-projects/",
                method: "POST",
                data: request,
                success: function(data, status, request) {
                    if(request.getResponseHeader('location') != null) {
                        window.location.href = request.getResponseHeader('location');
                    }
                    try {
                        var result = JSON.parse(data);
                        if(result['error'] == undefined) {
                            var html = '<table class="table table-striped"><thead><tr><th>#</th><th>Домен</th>';
                            html += '<th>Телефон менеджера</th><th>Дата регистрации</th><th></th><th></th></tr></thead><tbody>';
                            $.each(result['projects'], function(key, val) {
                                html += '<tr id="project_'+((page-1)*10+key+1)+'"><td>'+((page-1)*10+key+1)+'</td>';
                                html += '<td>'+val['domain']+'</td>';
                                html += '<td>'+val['managerPhone']+'</td>';
                                html += '<td>'+val['dateRegistration']+'</td>';
                                if(uid == undefined) {
                                    html += '<td><a href="/project-settings/project-'+val['apiKeyId']+'">Управление</a></td>';
                                } else {
                                    html += '<td><a href="/project-settings/user-'+uid+'/project-'+val['apiKeyId']+'">Управление</a></td>';
                                }
                                html += '<td><a href="#" title="Удалить проект" onClick="ControlPanel.delProject(\''+val['userId']+'\',\''+val['apiKeyId']+'\', \'project_'+((page-1)*10+key+1)+'\');"><span class="fontIconColor glyphicon glyphicon-remove-sign"></span></a></td></tr>';
                            });
                            html += '</tbody></table><div id="pagination"></div>';
                            $("#mainContent").html(html);
                            printPagination(page, result['countPages'], 'ControlPanel.fetchAllProjects');
                        } else {
                            throw result['error'];
                        }
                    } catch (e) {
                        $("#infoPanel").html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+e+'</div>');
                    }
                },
                complete: function() {
                    
                }
            });
        }
    }
}());

$(document).ready(function() {
    $("#saveMyInfo").click(function(){
        ControlPanel.saveUserInfo();
    });
    $("a").tooltip();
});