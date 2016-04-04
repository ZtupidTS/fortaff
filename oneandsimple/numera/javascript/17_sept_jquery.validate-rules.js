        $(document).ready(function() {
                               
				jQuery.validator.addMethod("lettersonly", function(value, element) {
					return this.optional(element) || /^[a-z]+$/i.test(value);
					}, "Please enter only letters without space."); 
					
                                 jQuery.validator.addMethod("integeronly", function(value, element) {
					return this.optional(element) || /^[\-\+]?\d+$/.test(value);
					}, "Not a valid integer.");
                                 
                                 jQuery.validator.addMethod("alphanumeric", function(value, element) {
					return this.optional(element) || /^[a-zA-Z0-9_]+$/.test(value);
					}, "Please enter alphanumeric without space");
                                 
                                        
                
                
// validate contact form on keyup and submit
                        //Vailidation for forgotpassword
			$("#forgotpassword").validate({			
			 errorElement: "span", 			 
			//set the rules for the fields
			rules: {			
				email: {
					required: true,
					email: true
				},
			},
			//set messages to appear inline
			messages: {
				userEmail: "Valid email is required.",
			},
                        errorPlacement: function(error, element) {    
                        error.appendTo(element.closest('.input-div').parent('div'))
			}
		});
                
                
                // validate contact form on keyup and submit
                        //Vailidation for Registeration
			$("#adminprofile").validate({			
			 errorElement: "div", 			 
			//set the rules for the fields
			rules: {			
				userName: {
					required: true,
					minlength: 5,
					maxlength:50,
				},
				userEmail: {
					required: true,
					email: true
				},
				userPhone: {
					required: true,
					minlength: 10,
					maxlength:100
				},
                                adminFooterTxt: {
					required: true,
				},
			},
			//set messages to appear inline
			messages: {
				userName: {
				required: "User Name is required.",
				minlength: "Your password must be at least 5 characters long",
				maxlength: "Password can not be more than 255 characters"
				},
				userPhone: {
				required: "Phone number is required.",
				minlength: "Phone number must be at least 9 characters long",
				maxlength: "Phone number can not be more than 12 characters"
				},
				userEmail: "Valid email is required.",
                                adminFooterTxt: "Footer text can not be empty, It is required."
			},
                        errorPlacement: function(error, element) {    
                                                error.appendTo(element.closest('.input-divs').parent('li'));
				}
		});
                
                
                
                
                
                        //Vailidation for Registeration
			$("#managefolder").validate({			
			 errorElement: "div", 			 
			//set the rules for the fields
			rules: {			
				parentfolderid: {
					required: true,
				},
				folderName: {
					required: true,
					alphanumeric: true
				},
			},
			//set messages to appear inline
			messages: {},
                        errorPlacement: function(error, element) {    
                        error.appendTo(element.closest('.input-divs').parent('li'));
			}
		});
                
                
                
                
                
                
                // validate contact form on keyup and submit
			$("#login").validate({
			 errorElement: "span", 
			//set the rules for the fields
			rules: {
				username: {
					required: true,
					minlength: 3,
					maxlength:200,
                                        alphanumeric:true,
				},
				password: {
					required: true,
					minlength: 6,
					maxlength:100
				}			
			},
			//set messages to appear inline
			messages: {
				name: {
					required: "Name is required..",
				},
				password: {
				required: "Enter you password.",
				minlength: "Password must be at least 6 characters long.",
				maxlength: "Password can not be more than 100 characters."
				},
			},
		errorPlacement: function(error, element) {               
					error.appendTo(element.closest('.input-div').parent('div'));    
				}
		});
                        
                /*Validate change password fields*/
                     //Vailidation for Registeration
			$("#changepassword").validate({			
			 errorElement: "div", 			 
			//set the rules for the fields
			rules: {			
				userPassword: {
					required: true,
					minlength: 8,
					maxlength:100
				},
                  		newuserPassword: {
					required: true,
					minlength: 8,
					maxlength:100
				},
                                confirmPassword: {
					required: true,
					minlength: 8,
					maxlength:100
				}

			},
			//set messages to appear inline
			messages: {
				userPassword: {
				required: "Enter your current password.",
				minlength: "Your password must be at least 8 characters long",
				maxlength: "Password can not be more than 100 characters"
				},
				newuserPassword: {
                                required: "Enter your new password.",
				minlength: "Your new password must be at least 8 characters long",
				maxlength: "New password can not be more than 100 characters"
                                },
                                confirmPassword: {
                                required: "Enter your confirm password.",
				minlength: "Your confirm password must be at least 8 characters long",
				maxlength: "Confirm password can not be more than 100 characters"
                               }
			},
		errorPlacement: function(error, element) {               
					error.appendTo(element.closest('.input-divs').parent('li'));      
				}
		});
                        
                        //Vailidation for client Search form of admin
			$("#searchform").validate({			
                                                errorElement: "div", 			 
                                               //set the rules for the fields
                                               rules: {			
                                                       searchvalue: {
                                                               required: true,
                                                               maxlength:100
                                                       }
                                               },
                                               //set messages to appear inline
                                               messages: {
                                                       searchvalue: {
                                                       required: "Search value is required.",
                                                       maxlength: "value can not be more than 100 characters"
                                                       }
                                               },
                                               errorPlacement: function(error, element) {               
                                                               error.appendTo(element.closest('.input-div').parent('div'));   
                                                       }
                        });
                       
                        //Vailidation for search for forntend
			
                        //Vailidation for search for forntend
			$("#frontsearchform").validate({			
			 errorElement: "div",
                         errorClass: 'divsearcherror',
			//set the rules for the fields
			rules: {			
				searchvalue: {
					required: true,
				},
                               
			},
			//set messages to appear inline
			messages: {
				searchvalue: {
				required: "Search value is required.",				
				}
			},
                        errorPlacement: function(error, element) {               
					error.appendTo(element.closest('.input-divs').parent('li'));
				}
                        });
                        
                        
                        
                        
                        
                        
                        
                        /*Validation for User registration*/
			$("#manageuser").validate({			
			 errorElement: "div", 			 
			//set the rules for the fields
			rules: {
                                userName: {
					required: true,
					minlength: 5,
					maxlength:200,
                                        alphanumeric:true
				},                
                                userPassword: {
					required: true,
					minlength: 8,
					maxlength:200,
                                        alphanumeric:true
				},
                                 newuserPassword: {
					minlength: 8,
					maxlength:255,
				},
				fname: {
					required: true,
					minlength: 3,
					maxlength:25
				},
                                lname: {
					required: true,
					minlength: 3,
					maxlength:25
				},
                                profession: {
					required: true,
					minlength: 2,
					maxlength:200
				},
                                
                                userEmail: {
					required: true,
					email: true
				},
				userPhone: {
					required: true,
                                        integeronly: true
				},
                                clientname:{
                                         required: true,       
                                },
                                userlanguage:{
                                         required: true,       
                                },
                                
			},
			//set messages to appear inline
			messages: {
				userPassword: {
				required: "Enter user password.",
				minlength: "Your password must be at least 8 characters long",
				maxlength: "Password can not be more than 200 characters"
				},
				userEmail: "Valid email is required.",
                                clientname: "Client name is required.",
                                userlanguage: "Language is required.",
			},
                        errorPlacement: function(error, element) {    
					         
					error.appendTo(element.closest('.input-divs').parent('li'));    
				}
		
                        });
                        
                        
                        
                        /*Validation for Client registration*/
			$("#manageclients").validate({			
			 errorElement: "div", 			 
			//set the rules for the fields
			rules: {
                                accountType: {
					required: true,
				},                
				userName: {
					required: true,
					minlength: 5,
					maxlength:200,
				},
				companyName: {
					required: true,
					minlength: 3,
					maxlength:150
				},
                                clientAddress: {
					required: true,
					minlength: 5,
					maxlength:500
				},
                                accountManager: {
					required: true,
					minlength: 2,
					maxlength:200
				},
                                
                                userEmail: {
					required: true,
					email: true,
				},
				userPhone: {
					required: true,
                                        integeronly: true,
				},
                                 googleemail: {
					required: true,
					email: true,
				},
                                googlepassword: {
					required: true,
					minlength: 8,
					maxlength:255,
				},
                                
                                newgooglepassword: {
					minlength: 8,
					maxlength:255,
				},
                                
                                personname: {
					required: true,
					minlength: 5,
					maxlength:25,
				},
                                personprofession: {
					required: true,
					minlength: 2,
					maxlength:200,
				},
                                
                                personemail: {
					required: true,
					email: true,
				},
				personphone: {
					required: true,
                                        integeronly: true
				},
                                serviceName: {
					required: true,
					minlength: 5,
					maxlength:250,
				},
                                serviceDescription: {
					required: true,
					minlength: 5,
					maxlength:500
				},
                                startingDate: {
					required: true,
				},
                                endingDate: {
					required: true,
				},
			},
			//set messages to appear inline
			messages: {
				userName: {
					required: "User name is required..",
				},
                                googleemail: {
				required: "Google email is required.",
				},
				googlepassword: {
				required: "Google password is required.",
				minlength: "Your password must be at least 8 characters long",
				maxlength: "Password can not be more than 255 characters"
				},
				userEmail: "Valid email is required."
			},
                        errorPlacement: function(error, element) {    
					         
					error.appendTo(element.closest('.input-divs').parent('li'));    
				}
		
                        });
                        
                        
                        /*Validation for add Service of client*/
			$("#manageclientservice").validate({			
			 errorElement: "div", 			 
			//set the rules for the fields
			rules: {			
				serviceName: {
					required: true,
					minlength: 5,
					maxlength:250,
				},
                                serviceDescription: {
					required: true,
					minlength: 5,
					maxlength:500
				},
                                startingDate: {
					required: true,
				},
                                endingDate: {
					required: true,
				},
			},
			//set messages to appear inline
			messages: {
				serviceName: {
					required: "User name is required..",
				},
			},
                        errorPlacement: function(error, element) {    
					         
					error.appendTo(element.closest('.input-divs').parent('li'));    
				}
		
                        });
                        
                        /*Validation for User registration*/
			$("#savecontactperson").validate({			
			 errorElement: "div", 			 
			//set the rules for the fields
			rules: {			
				name: {
					required: true,
					minlength: 5,
					maxlength:25,
				},
                                profession: {
					required: true,
					minlength: 2,
					maxlength:200,
				},
                                
                                email: {
					required: true,
					email: true
				},
				phone: {
					required: true,
                                        integeronly: true,
				},
                                
			},
			//set messages to appear inline
			messages: {
				userName: {
					required: "User name is required..",
				},
				userEmail: "Valid email is required."
			},
                        errorPlacement: function(error, element) {    
					         
					error.appendTo(element.closest('.input-divs').parent('li'));    
				}
		
                        });
	});
