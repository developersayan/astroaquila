<?php

Route::group(['namespace' => 'Admin'], function() {

    Route::get('/', 'HomeController@index')->name('admin.dashboard');

    // Login
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');
    Route::get('logout', 'Auth\LoginController@logout')->name('admin.logout');

    // Register
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('admin.register');
    Route::post('register', 'Auth\RegisterController@register');

    // Passwords
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');

    // forget-password
    Route::get('forget-password','Auth\ForgotPasswordController@index')->name('admin.forget.password');
    Route::post('forget-password/email','Auth\ForgotPasswordController@forgetpassword')->name('admin.forget.password.email');
    Route::get('reset-password/{id}/{vcode}','Auth\ForgotPasswordController@resetPassowrd')->name('admin.forget.password.email.verify');
    Route::post('reset-new-password','Auth\ForgotPasswordController@newPassword')->name('admin.reset.new.password');
    // change-password
    Route::get('change-password','HomeController@changepasswordview')->name('admin.change.password');
    Route::get('change-password/check-old-password','HomeController@checkold')->name('admin.check.oldpassword');
    Route::post('change-password/change-new-password','HomeController@newpassword')->name('admin.change.new.password');
    Route::get('admin-profile','HomeController@profile')->name('admin.manage.profile');
    Route::get('admin-profile/check-email','HomeController@checkemail')->name('admin.manage.profile.checkemail');
    Route::post('admin-profile/update-profile','HomeController@updateprofile')->name('admin.update.profile');
    // Verify
    // Route::get('email/resend', 'Auth\VerificationController@resend')->name('admin.verification.resend');
    // Route::get('email/verify', 'Auth\VerificationController@show')->name('admin.verification.notice');
    // Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('admin.verification.verify');
    Route::get('product-category', 'Modules\Product\ProductCategoryController@index')->name('admin.product.category.manage');
    Route::post('product-category', 'Modules\Product\ProductCategoryController@index')->name('admin.product.category.manage');
    Route::get('add-product-category', 'Modules\Product\ProductCategoryController@addProductCategory')->name('admin.product.category.add');
    Route::post('add-product-category-save', 'Modules\Product\ProductCategoryController@addProductCategorySave')->name('admin.product.category.add.save');
    Route::get('edit-product-category/{id}', 'Modules\Product\ProductCategoryController@editProductCategory')->name('admin.product.category.edit');
    Route::post('edit-product-category-save/{id}', 'Modules\Product\ProductCategoryController@editProductCategorySave')->name('admin.product.category.edit.save');
    Route::get('status-change-product-category/{id}', 'Modules\Product\ProductCategoryController@statusChangeProductCategory')->name('admin.product.category.status.change');
    Route::get('delete-product-category/{id}', 'Modules\Product\ProductCategoryController@deleteProductCategory')->name('admin.product.category.delete');
    Route::post('product-category/check-name','Modules\Product\ProductCategoryController@checkname')->name('admin.product.checkname');


    // product-subcategory
    Route::get('add-sub-category','Modules\Product\ProductCategoryController@addSubCategory')->name('admin.product.sub-category.add');
    Route::post('add-sub-category-save', 'Modules\Product\ProductCategoryController@subcategoryRegister')->name('admin.product.sub-category-save');
    Route::get('edit-product-sub-category/{id}', 'Modules\Product\ProductCategoryController@editProductSubCategory')->name('admin.product.sub-category.edit');
    Route::post('edit-product-sub-category/update', 'Modules\Product\ProductCategoryController@subCategoryUpdate')->name('admin.product.sub-category.update');
    Route::get('product-sub-category-check','Modules\Product\ProductCategoryController@checksub')->name('admin.product.sub-category-check');

    Route::post('product-category/delete-image','Modules\Product\ProductCategoryController@deleteImage')->name('admin.product.category.delete.image');

	//Gemstone Category
	Route::get('gemstone-category', 'Modules\ManageGemstones\ManageGemstoneController@index')->name('admin.gemstone.category.manage');
    Route::post('gemstone-category', 'Modules\ManageGemstones\ManageGemstoneController@index')->name('admin.gemstone.category.manage');
    Route::get('add-gemstone-category', 'Modules\ManageGemstones\ManageGemstoneController@addGemstoneCategory')->name('admin.gemstone.category.add');
    Route::post('add-gemstone-category-save', 'Modules\ManageGemstones\ManageGemstoneController@addGemstoneCategorySave')->name('admin.gemstone.category.add.save');
    Route::get('edit-gemstone-category/{id}', 'Modules\ManageGemstones\ManageGemstoneController@editGemstoneCategory')->name('admin.gemstone.category.edit');
    Route::post('edit-gemstone-category-save/{id}', 'Modules\ManageGemstones\ManageGemstoneController@editGemstoneCategorySave')->name('admin.gemstone.category.edit.save');
    Route::get('status-change-gemstone-category/{id}', 'Modules\ManageGemstones\ManageGemstoneController@statusChangeGemstoneCategory')->name('admin.gemstone.category.status.change');
    Route::get('delete-gemstone-category/{id}', 'Modules\ManageGemstones\ManageGemstoneController@deleteGemstoneCategory')->name('admin.gemstone.category.delete');
    Route::post('gemstone-category/check-name','Modules\ManageGemstones\ManageGemstoneController@checkname')->name('admin.gemstone.checkname');

    Route::post('gemstone-category/delete-image','Modules\ManageGemstones\ManageGemstoneController@deleteCategoryImage')->name('admin.gemstone.category.image.delete');




    // manage-customer/////////////////////////////////////////////////////////////////////
    Route::get('manage-customer', 'Modules\Customer\CustomerController@index')->name('admin.manage.customer');
    Route::post('manage-customer', 'Modules\Customer\CustomerController@index')->name('admin.manage.search');
    Route::get('manage-customer/change-status/{id}','Modules\Customer\CustomerController@status')->name('admin.customer.status');
    Route::get('manage-customer/delete-customer/{id}','Modules\Customer\CustomerController@delete')->name('admin.customer.delete');
    Route::get('manage-customer/view/{id}','Modules\Customer\CustomerController@view')->name('admin.customer.view');
    Route::get('manage-customer/reset-password/{id}','Modules\Customer\CustomerController@userResetPassword')->name('admin.customer.reset.password');

    // manage-astrologer
    Route::get('manage-astrologer','Modules\Astrologer\AstrologerController@index')->name('admin.manage.astrologer');
    Route::post('manage-astrologer','Modules\Astrologer\AstrologerController@index')->name('admin.manage.astrologer.search');
    Route::get('manage-astrologer/change-status/{id}','Modules\Astrologer\AstrologerController@status')->name('admin.astrologer.status');
    Route::get('manage-astrologer/approve/{id}','Modules\Astrologer\AstrologerController@approve')->name('admin.astrologer.approve');
    Route::get('manage-astrologer/delete/{id}','Modules\Astrologer\AstrologerController@delete')->name('admin.astrologer.delete');
    Route::get('manage-astrologer/view/{id}','Modules\Astrologer\AstrologerController@view')->name('admin.astrologer.view');
	Route::get('manage-astrologer/reset-password/{id}','Modules\Astrologer\AstrologerController@userResetPassword')->name('admin.astrologer.reset.password');
	Route::post('manage-astrologer/get-city','Modules\Astrologer\AstrologerController@getCity')->name('admin.astrologer.get.city');
	Route::post('manage-astrologer/get-area','Modules\Astrologer\AstrologerController@gateArea')->name('admin.astrologer.get.area');

    // astrologer-faq
    Route::get('manage-astrologer/faq/{id}','Modules\Faq\FaqController@manageFaqAstro')->name('admin.manage.astrologer.faq');
    Route::get('manage-astrologer/add-faq/{id}','Modules\Faq\FaqController@addFaqAstroView')->name('admin.manage.astrologer.faq.add-view');

    Route::get('manage-astrologer/edit-faq/{faq}','Modules\Faq\FaqController@editFaqAstroView')->name('admin.manage.astrologer.faq.edit-view');

    Route::any('manage-astrologer/add-general-faq/{faq}','Modules\Faq\FaqController@astroGeneral')->name('admin.manage.astrologer.add.general-faq');

    Route::post('manage-astrologer/insert-general-faq','Modules\Faq\FaqController@addAstroGeneral')->name('admin.manage.astrologer.insert.general-faq');






    Route::get('manage-astrologer/edit/edit-profile/{id}','Modules\Astrologer\AstrologerController@editview')->name('admin.astrologer.edit-view');
    Route::get('manage-astrologer/get-state','Modules\Astrologer\AstrologerController@getstate')->name('admin.astrologer.get-state');
    Route::post('manage-astrologer/update-profile','Modules\Astrologer\AstrologerController@updateprofile')->name('admin.astrologer.update-profile');
    Route::post('manage-astrologer/check-email','Modules\Astrologer\AstrologerController@checkemail')->name('admin.astrologer.check-email');
    Route::post('manage-astrologer/check-mobile','Modules\Astrologer\AstrologerController@checkmobile')->name('admin.astrologer.check-mobile');
    Route::post('manage-astrologer/delete-profile-picture','Modules\Astrologer\AstrologerController@delProfilePicture')->name('admin.astrologer.delete.profile.picture');

    // astrologer-education///////////////////////////////
    Route::get('manage-astrologer/edit/education/{id}','Modules\Astrologer\AstrologerController@editeduview')->name('admin.astrologer.edit-education-view');
    Route::get('manage-astrologer/edit/edit-education/{edu?}','Modules\Astrologer\AstrologerController@editedu')->name('admin.astrologer.edit-education');
    Route::post('manage-astrologer/edit/add-education','Modules\Astrologer\AstrologerController@addedu')->name('admin.astrologer.add-education');
    Route::post('manage-astrologer/edit/update-education','Modules\Astrologer\AstrologerController@update_education')->name('admin.astrologer.update-education');
    Route::get('manage-astrologer/edit/delete-education/{edu?}','Modules\Astrologer\AstrologerController@delete_education')->name('admin.astrologer.delete-education');
    Route::get('manage-astrologer/edit/check-education','Modules\Astrologer\AstrologerController@checkedu')->name('admin.astrologer.check-education');

    Route::post('manage-astrologer/delete-education-image','Modules\Astrologer\AstrologerController@deleteEducationImage')->name('admin.astrologer.delete.eduction.image');


    // astrologer-experience//////////////////////////////
    Route::get('manage-astrologer/edit/experience/{id}','Modules\Astrologer\AstrologerController@editexpview')->name('admin.astrologer.edit-exp-view');
    Route::post('manage-astrologer/edit/add-experience','Modules\Astrologer\AstrologerController@addexp')->name('admin.astrologer.add-experience');
    Route::get('manage-astrologer/edit/delete-experience/{exp}','Modules\Astrologer\AstrologerController@delete_exp')->name('admin.astrologer.delete-experience');
    Route::get('manage-astrologer/edit/edit-experience/{exp}','Modules\Astrologer\AstrologerController@edit_exp')->name('admin.astrologer.edit-experience');
    Route::post('manage-astrologer/edit/update-experience','Modules\Astrologer\AstrologerController@update_exp')->name('admin.astrologer.update-experience');
    Route::get('manage-astrologer/edit/check-experience','Modules\Astrologer\AstrologerController@check_exp')->name('admin.astrologer.check-experience');
    Route::get('manage-astrologer/show-at-home/{id}','Modules\Astrologer\AstrologerController@showHome')->name('admin.manage.astrologer.show.home');

    Route::post('manage-astrologer/delete-experience-image','Modules\Astrologer\AstrologerController@deleteExperienceImage')->name('admin.astrologer.delete.experience.image');

    // astrologer-date-exclusion
    Route::any('manage-astrologer/date-exclusion/{id}','Modules\Astrologer\AstrologerController@dateExclusion')->name('admin.astrologer.date.exclusion');
    Route::post('manage-astrologer/insert-date-exclusion','Modules\Astrologer\AstrologerController@dateInsert')->name('admin.astrologer.date.exclusion.insert');
    Route::get('manage-astrologer/delete-date-exclusion/{id}','Modules\Astrologer\AstrologerController@deleteDate')->name('admin.astrologer.date.exclusion.delete');


    // manage-expertise
    Route::any('manage-expertise','Modules\Expertise\ExpertiseController@index')->name('admin.manage.expertise');
    Route::get('manage-expertise/add-expertise','Modules\Expertise\ExpertiseController@addView')->name('admin.expertise.add-view');
    Route::post('manage-expertise/check','Modules\Expertise\ExpertiseController@check')->name('admin.expertise.check');
    Route::post('manage-expertise/insert','Modules\Expertise\ExpertiseController@add')->name('admin.expertise.add');
    Route::get('manage-expertise/delete-expertise/{id}','Modules\Expertise\ExpertiseController@delete')->name('admin.expertise.delete');
    Route::get('manage-expertise/edit-expertise/{id}','Modules\Expertise\ExpertiseController@edit')->name('admin.expertise.edit-view');
    Route::post('manage-expertise/update-expertise','Modules\Expertise\ExpertiseController@update')->name('admin.expertise.update');
    // astrologer-availibilty
    Route::get('manage-astrologer/edit/availability/{id}','Modules\Astrologer\AstrologerController@editavailview')->name('admin.astrologer.edit-avail-view');
    Route::post('manage-astrologer/edit/update-avail','Modules\Astrologer\AstrologerController@updateavail')->name('admin.astrologer.update-avail');




    // manage-pandit///////////////
    Route::get('manage-pundit','Modules\Pandit\PanditController@index')->name('admin.manage.pandit');
    Route::post('manage-pundit','Modules\Pandit\PanditController@index')->name('admin.manage.pandit.search');
    Route::get('manage-pundit/status/{id}','Modules\Pandit\PanditController@status')->name('admin.pundit.status');
    Route::get('manage-pundit/approve/{id}','Modules\Pandit\PanditController@approve')->name('admin.pundit.approve');
    Route::get('manage-pundit/delete/{id}','Modules\Pandit\PanditController@delete')->name('admin.pundit.delete');
    Route::get('manage-pundit/view/{id}','Modules\Pandit\PanditController@view')->name('admin.pundit.view');
	Route::get('manage-pundit/reset-password/{id}','Modules\Pandit\PanditController@userResetPassword')->name('admin.pundit.reset.password');
    // profile-edit///////////////
    Route::get('manage-pundit/edit/profile/{id}','Modules\Pandit\PanditController@editview')->name('admin.pundit.edit-view');
    Route::get('manage-pundit/edit/get-states','Modules\Pandit\PanditController@getstate')->name('admin.pundit.getstate');
    Route::post('manage-pundit/edit/check-email','Modules\Pandit\PanditController@checkemail')->name('admin.pundit.check-email');
    Route::post('manage-pundit/edit/check-mobile','Modules\Pandit\PanditController@checkmobile')->name('admin.pundit.check-mobile');
    Route::post('manage-pundit/edit/update-profile','Modules\Pandit\PanditController@updateprofile')->name('admin.pundit.update-profile');


    Route::get('manage-pundit/puja-lists/{id}','Modules\Pandit\PanditController@pujaList')->name('admin.pundit.puja.list');


   // puja-edit
   Route::get('manage-pundit/edit/puja/{id}','Modules\Pandit\PanditController@editpujaview')->name('admin.pundit.edit-puja-view');
   Route::post('manage-pundit/edit/add-puja','Modules\Pandit\PanditController@addpuja')->name('admin.pundit.add-puja');
   Route::get('manage-pundit/edit/delete-puja/{id}','Modules\Pandit\PanditController@deletepuja')->name('admin.pundit.delete-puja');
   Route::get('manage-pundit/edit/edit-puja/{id}','Modules\Pandit\PanditController@editpuja')->name('admin.pundit.edit-puja');
    Route::post('manage-pundit/edit/update-puja','Modules\Pandit\PanditController@updatepuja')->name('admin.pundit.update-puja');

    // zipcode-edit
    Route::get('manage-pundit/edit/zipcode/{id}','Modules\Pandit\PanditController@editZipcode')->name('admin.pundit.edit-zipcode-view');
    Route::post('manage-pundit/add-zipcode','Modules\Pandit\PanditController@addZipCode')->name('admin.pundit.add-zipcode');
    Route::get('manage-pundit/delete-zipcode/{id}','Modules\Pandit\PanditController@delZipcode')->name('admin.pundit.delete-zipcode');
    Route::get('manage-pundit/get-zipcode','Modules\Pandit\PanditController@getZipcode')->name('admin.pundit.get-zipcode');
    Route::get('manage-pundit/check-zipcode/service','Modules\Pandit\PanditController@checkZipcode')->name('admin.pundit.check-zipcode-service');


   Route::get('manage-pundit/edit/availability/{id}','Modules\Pandit\PanditController@editavail')->name('admin.pundit.edit-avail');
    Route::post('manage-pundit/edit/update-avail','Modules\Pandit\PanditController@updateavail')->name('admin.pundit.update-avail');
    // manage-state
    Route::get('manage-state','Modules\State\StateController@index')->name('manage.state');
    Route::post('manage-state','Modules\State\StateController@index')->name('manage.state.search');
    Route::get('manage-state/delete/{id}','Modules\State\StateController@delete')->name('manage.state.delete');
    Route::get('manage-state/add-view','Modules\State\StateController@addview')->name('manage.state.add.view');
    Route::post('manage-state/add','Modules\State\StateController@add')->name('manage.state.add');
    Route::get('manage-state/edit/{id}','Modules\State\StateController@edit')->name('manage.state.edit');
    Route::post('manage-state/update','Modules\State\StateController@update')->name('manage.state.update');
    Route::get('manage-state/check-state','Modules\State\StateController@checkstate')->name('manage.state.check');

    // manage-city
    Route::any('manage-city','Modules\City\CityController@index')->name('admin.manage.city');
    Route::get('manage-city/add-city','Modules\City\CityController@addView')->name('admin.manage.city.add-view');
    Route::get('manage-city/get-state','Modules\City\CityController@getState')->name('admin.manage.city.get-state');
    Route::get('manage-city/check-city','Modules\City\CityController@checkState')->name('admin.manage.city.check-city');
    Route::post('manage-city/add-city','Modules\City\CityController@add')->name('admin.manage.city.add');
    Route::get('manage-city/edit-city/{id}','Modules\City\CityController@editView')->name('admin.manage.city.edit-view');
    Route::get('manage-city/delete-city/{id}','Modules\City\CityController@delete')->name('admin.manage.city.delete');

    Route::post('manage-city/update-city','Modules\City\CityController@update')->name('admin.manage.city.update');

    Route::get('manage-city/excel-upload','Modules\City\CityController@excelUpload')->name('admin.manage.excel.upload');
    Route::post('manage-city/export-city','Modules\City\CityController@export')->name('admin.manage.city.export');

    // Postcode
    Route::get('manage-postcode','Modules\Postcode\PostcodeManagement@managePostCode')->name('admin.manage.postcode');
    Route::get('manage-postcode/add-postcode','Modules\Postcode\PostcodeManagement@addPostCode')->name('admin.manage.postcode.add');
    Route::get('manage-postcode/edit-postcode/{id}','Modules\Postcode\PostcodeManagement@addPostCode')->name('admin.manage.postcode.edit');
    Route::post('manage-postcode/insert-postcode','Modules\Postcode\PostcodeManagement@updatePostCode')->name('admin.manage.postcode.insert');
    Route::post('manage-postcode/update-postcode','Modules\Postcode\PostcodeManagement@updatePostCode')->name('admin.manage.postcode.update');
    Route::post('manage-postcode/get-state','Modules\Postcode\PostcodeManagement@getState')->name('admin.manage.postcode.get.state');
    Route::post('manage-postcode/get-city','Modules\Postcode\PostcodeManagement@getCity')->name('admin.manage.postcode.get.city');
    Route::get('manage-postcode/check-duplicate-postcode','Modules\Postcode\PostcodeManagement@checkDuplicatePostcode')->name('admin.manage.postcode.check.postcode');
    Route::get('manage-postcode/delete-postcode/{id}','Modules\Postcode\PostcodeManagement@deletePostcode')->name('admin.manage.postcode.delete');
    Route::post('manage-postcode/export-postcode','Modules\Postcode\PostcodeManagement@exportPostcode')->name('admin.manage.postcode.export');
    // manage-puja
    Route::get('manage-puja','Modules\Puja\PujaController@index')->name('admin.manage.puja');
    Route::post('manage-puja','Modules\Puja\PujaController@index')->name('admin.manage.puja.search');
    Route::get('manage-puja/add-puja','Modules\Puja\PujaController@addview')->name('admin.manage.puja.add');
    Route::post('manage-puja/register-puja','Modules\Puja\PujaController@add')->name('admin.manage.puja.register');
    Route::get('manage-puja/check-puja','Modules\Puja\PujaController@check')->name('admin.manage.puja.check');
    Route::get('manage-puja/delete-puja/{id}','Modules\Puja\PujaController@delete')->name('admin.manage.puja.delete');
    Route::get('manage-puja/edit-puja/{id}','Modules\Puja\PujaController@editview')->name('admin.manage.puja.edit');
    Route::post('manage-puja/update-puja','Modules\Puja\PujaController@update')->name('admin.manage.puja.update');
    Route::get('manage-puja/show-at-home/{id}','Modules\Puja\PujaController@showAtHome')->name('admin.manage.puja-show-at-home');
    Route::get('manage-puja/get-sub-category','Modules\Puja\PujaController@getSubCat')->name('admin.manange.puja.get.sub-cat');

    Route::post('manage-puja/delete-puja-image','Modules\Puja\PujaController@deleteImage')->name('admin.manage.puja.delete.image');
    Route::post('manage-puja/delete-puja-video','Modules\Puja\PujaController@deleteVideo')->name('admin.manage.puja.delete.video');
    // astro tips
    Route::get('manage-astro-tips','Modules\AstroTips\AstroTipController@manageAstroTips')->name('admin.manage.astro.tips');
    Route::get('add-astro-tips','Modules\AstroTips\AstroTipController@editAstroTips')->name('admin.add.astro.tips');
    Route::post('insert-astro-tips','Modules\AstroTips\AstroTipController@editAstroTips')->name('admin.insert.astro.tips');
    Route::get('edit-astro-tips/{id}','Modules\AstroTips\AstroTipController@editAstroTips')->name('admin.edit.astro.tips');
    Route::post('update-astro-tips/{id}','Modules\AstroTips\AstroTipController@editAstroTips')->name('admin.update.astro.tips');
    Route::get('delete-astro-tips/{id}','Modules\AstroTips\AstroTipController@deleteAstroTips')->name('admin.delete.astro.tips');
    // manage-trunsaction
    Route::get('manage-transaction','Modules\Transaction\TransactionController@index')->name('admin.manage.transaction');
    Route::post('manage-transaction','Modules\Transaction\TransactionController@index')->name('admin.manage.transaction.search');

    // manage-commision
    Route::get('manage-comission','Modules\Commision\CommissionController@index')->name('admin.manage.commission');
    Route::post('manage-comission','Modules\Commision\CommissionController@index')->name('admin.manage.commission.search');
    Route::post('manage-commision/update','Modules\Commision\CommissionController@comission_update')->name('admin.manage.commission.update');
    Route::get('manage-comission/edit-commission/{id}','Modules\Commision\CommissionController@edit_commission_view')->name('admin.manage.edit-commission');
    Route::post('manage-comission/update-commission','Modules\Commision\CommissionController@update_indi_com')->name('admin.manage.update-commission');

	// manage gemstones
    Route::get('manage-gemstones','Modules\ManageGemstones\ManageGemstoneController@manageGemstone')->name('admin.manage.gemstone');
    Route::post('manage-gemstones','Modules\ManageGemstones\ManageGemstoneController@manageGemstone')->name('admin.manage.gemstone.search');
	Route::get('manage-gemstones/add-gemstones','Modules\ManageGemstones\ManageGemstoneController@addView')->name('admin.manage.add-gemstone-view');
	Route::post('manage-gemstones/save-gemstone','Modules\ManageGemstones\ManageGemstoneController@addGemstone')->name('admin.manage.add-gemstone');
	Route::get('manage-gemstones/check-duplicate-gemstone','Modules\ManageGemstones\ManageGemstoneController@checkGemstone')->name('admin.manage.check-gemstone');
	Route::post('manage-gemstones/gemstone-duplicate','Modules\ManageGemstones\ManageGemstoneController@gemstoneCodeDuplicate')->name('admin.check.gemstone.code');
	Route::get('manage-gemstones/edit/{id}','Modules\ManageGemstones\ManageGemstoneController@editView')->name('admin.manage.edit-gemstone');
    Route::post('manage-gemstones/update-gemstone','Modules\ManageGemstones\ManageGemstoneController@updateGemstone')->name('admin.manage.update-gemstone');
	Route::get('manage-gemstones/delete-gemstone-image/{id}','Modules\ManageGemstones\ManageGemstoneController@deleteGemstoneImage')->name('admin.manage.delete-gemstone-image');

    Route::post('manage-gemstones/change-default','Modules\ManageGemstones\ManageGemstoneController@changedefault')->name('admin.manage.gemstone-change-default');
	Route::get('manage-gemstones/show-at-home/{id}','Modules\ManageGemstones\ManageGemstoneController@showHome')->name('admin.manage.gemstone.show-at-home');
	Route::get('manage-gemstones/status/{id}','Modules\ManageGemstones\ManageGemstoneController@status')->name('admin.manage.gemstone.status');
    Route::get('manage-gemstones/delete/{id}','Modules\ManageGemstones\ManageGemstoneController@gemstoneDelete')->name('admin.manage.gemstone.delete');


    Route::get('manage-gemstone/get-sub-title','Modules\ManageGemstones\ManageGemstoneController@getSubtitle')->name('admin.manage.gemstone.get-sub-title');

    Route::post('manage-gemstone-price/delete-video','Modules\ManageGemstones\ManageGemstoneController@deleteVideo')->name('admin.manage.gemstone.delete.video');

	//Manage gemstone price
	Route::get('manage-gemstone-price','Modules\ManageGemstones\ManageGemstoneController@manageGemstonePrice')->name('admin.manage.gemstone.price');
	Route::post('manage-gemstone-price','Modules\ManageGemstones\ManageGemstoneController@manageGemstonePrice')->name('admin.manage.gemstone.price');
	Route::get('manage-gemstone-price/save-gemstone-price/{id?}','Modules\ManageGemstones\ManageGemstoneController@addGemstonePrice')->name('admin.manage.add-gemstone-price');
	Route::post('manage-gemstone-price/fetch-base-price','Modules\ManageGemstones\ManageGemstoneController@fetchGemstonePrice')->name('admin.fetch.gemstone.price');
	Route::post('manage-gemstone-price/delete-gemstone-price','Modules\ManageGemstones\ManageGemstoneController@deleteGemstonePrice')->name('admin.manage.delete-gemstone-price');
	Route::post('manage-gemstone-price/save-gemstone-price','Modules\ManageGemstones\ManageGemstoneController@saveGemstonePrice')->name('admin.manage.save-gemstone-price');



    // manage-products
    Route::get('manage-products','Modules\ManageProducts\ManageProductController@index')->name('admin.manage.product');
    Route::post('manage-products','Modules\ManageProducts\ManageProductController@index')->name('admin.manage.product.search');
    Route::get('manage-products/status/{id}','Modules\ManageProducts\ManageProductController@status')->name('admin.manage.product.status');
    Route::get('manage-products/delete/{id}','Modules\ManageProducts\ManageProductController@product_delete')->name('admin.manage.product.delete');
    Route::get('manage-products/add-product','Modules\ManageProducts\ManageProductController@addView')->name('admin.manage.add-product-view');
	Route::post('manage-products/product-duplicate','Modules\ManageProducts\ManageProductController@productCodeDuplicate')->name('admin.check.product.code');


    Route::post('manage-products/register-product','Modules\ManageProducts\ManageProductController@addproduct')->name('admin.manage.add-product');
    Route::get('manage-products/check-duplicate-product','Modules\ManageProducts\ManageProductController@checkproduct')->name('admin.manage.check-product');

    Route::get('manage-products/edit/{id}','Modules\ManageProducts\ManageProductController@editView')->name('admin.manage.edit-product');
    Route::post('manage-products/update-product','Modules\ManageProducts\ManageProductController@updateProduct')->name('admin.manage.update-product');

    Route::get('manage-products/delete-product-image/{id}','Modules\ManageProducts\ManageProductController@deleteProductImage')->name('admin.manage.delete-product-product-image');

    Route::post('manage-products/change-default','Modules\ManageProducts\ManageProductController@changedefault')->name('admin.manage.change-default');
    // get-sub-category
    Route::get('manage-products/get-sub-category','Modules\ManageProducts\ManageProductController@getSubCategory')->name('admin.manage.get.sub-category');
    Route::get('manage-products/product-sub-category-check','Modules\ManageProducts\ManageProductController@checkSubProduct')->name('admin.manage.check.sub-category-product');
    Route::get('manage-products/show-at-home/{id}','Modules\ManageProducts\ManageProductController@showHome')->name('admin.manage.product.show-at-home');

    // manage-remedy////////////////////////////////////////////
    Route::get('manage-remedies','Modules\Remedy\ManageRemedyController@index')->name('admin.manage.remedy');
    Route::post('manage-remedies','Modules\Remedy\ManageRemedyController@index')->name('admin.manage.remedy.search');
    Route::get('manage-remedies/add-remedy','Modules\Remedy\ManageRemedyController@addView')->name('admin.manage.add-view-remedy');
    Route::post('manage-remedies/register-remedy','Modules\Remedy\ManageRemedyController@remedyadd')->name('admin.manage.add-remedy');
    Route::get('manage-remedy/check-duplicate-remedy','Modules\Remedy\ManageRemedyController@checkremedy')->name('admin.manage.check-remedy');
    Route::get('manage-remedies/delete/{id}','Modules\Remedy\ManageRemedyController@delete')->name('admin.manage.delete-remedy');

    Route::get('manage-remedies/edit/{id}','Modules\Remedy\ManageRemedyController@editview')->name('admin.manage.edit-remedy');
    Route::post('manage-remedies/update-remedy','Modules\Remedy\ManageRemedyController@update')->name('admin.manage.update-remedy');


    // manage-seller
    Route::get('manage-sellers-sign-up','Modules\ManageSeller\ManageSellerController@index')->name('admin.manage.seller');
    Route::post('manage-sellers-sign-up','Modules\ManageSeller\ManageSellerController@index')->name('admin.manage.seller.search');
    Route::get('/download/{file?}','Modules\ManageSeller\ManageSellerController@download')->name('admin.seller.download.file');
    Route::get('manage-sellers-sign-up/delete/{id}','Modules\ManageSeller\ManageSellerController@delete')->name('admin.manage.seller.delete');
    Route::get('manage-sellers-sign-up/view/{id}','Modules\ManageSeller\ManageSellerController@view')->name('admin.manage.seller.view');


    // manage-blog-category
    Route::get('manage-blog-category','Modules\BlogCategory\BlogCatgeoryController@index')->name('admin.manage.blog.category');
    Route::post('manage-blog-category','Modules\BlogCategory\BlogCatgeoryController@index')->name('admin.manage.blog.category.search');
    Route::get('manage-blog-category/add-category','Modules\BlogCategory\BlogCatgeoryController@addview')->name('admin.manage.add-blog-category-view');
    Route::post('manage-blog-category/register-category','Modules\BlogCategory\BlogCatgeoryController@addCategory')->name('admin.manage.add-blog-category');
    Route::post('manage-blog-category/check-category','Modules\BlogCategory\BlogCatgeoryController@check')->name('admin.manage.add-blog-category-check');
    Route::get('manage-blog-category/change-status/{id}','Modules\BlogCategory\BlogCatgeoryController@status')->name('admin.manage.blog-category-status');
    Route::get('manage-blog-category/delete-category/{id}','Modules\BlogCategory\BlogCatgeoryController@deleteCategory')->name('admin.manage.blog-category-delete');
     Route::get('manage-blog-category/edit-category/{id}','Modules\BlogCategory\BlogCatgeoryController@editView')->name('admin.manage.edit-blog-category-view');
     Route::post('manage-blog-category/update-category','Modules\BlogCategory\BlogCatgeoryController@updateCategory')->name('admin.manage.update-blog-category');

     // blog-manage
     Route::get('manage-blog','Modules\Blog\BlogController@index')->name('admin.manage.blog');
     Route::post('manage-blog','Modules\Blog\BlogController@index')->name('admin.manage.blog.search');
     Route::get('manage-blog/add-blog','Modules\Blog\BlogController@addBlogView')->name('admin.manage.add.blog-view');
     Route::post('manage-blog/add-blog','Modules\Blog\BlogController@addBlog')->name('admin.manage.add.blog');
     Route::post('manage-blog/check-image-size','Modules\Blog\BlogController@checkSize')->name('admin.check.img.size');
     Route::get('manage-blog/check-blog-name','Modules\Blog\BlogController@checkBlogName')->name('admin.check.blog-name');
     Route::get('manage-blog/edit-blog/{id}','Modules\Blog\BlogController@editBlogView')->name('admin.manage.edit-blog-view');
     Route::post('manage-blog/edit-blog','Modules\Blog\BlogController@editBlog')->name('admin.manage.edit.blog');
     Route::get('manage-blog/status/{id}','Modules\Blog\BlogController@status')->name('admin.manage.change.blog-status');
     Route::get('manage-blog/delete/{id}','Modules\Blog\BlogController@delBlog')->name('admin.manage.delete.blog-delete');

     Route::get('manage-blog/featured/{id}','Modules\Blog\BlogController@featured')->name('admin.manage.featured.blog-featured');

     // manage-deity
     Route::get('manage-deity','Modules\Deity\ManageDeityController@index')->name('admin.manage.deity');
     Route::post('manage-deity','Modules\Deity\ManageDeityController@index')->name('admin.manage.deity.search');
     Route::get('manage-deity/add-deity','Modules\Deity\ManageDeityController@addView')->name('admin.manage.deity-add-view');
     Route::post('manage-deity/check-deity','Modules\Deity\ManageDeityController@checkDeity')->name('admin.manage.deity-check');
     Route::post('manage-deity/register-deity','Modules\Deity\ManageDeityController@addDeity')->name('admin.manage.deity-add');
     Route::get('manage-deity/edit-deity/{id}','Modules\Deity\ManageDeityController@editView')->name('admin.manage.deity-edit-view');
     Route::post('manage-deity/update-deity','Modules\Deity\ManageDeityController@updateDeity')->name('admin.manage.deity-update');
      Route::get('manage-deity/delete-deity/{id}','Modules\Deity\ManageDeityController@deletDeity')->name('admin.manage.deity-delete');
	  // manage-planet
     Route::get('manage-planet','Modules\Planets\PlanetController@index')->name('admin.manage.planet');
     Route::post('manage-planet','Modules\Planets\PlanetController@index')->name('admin.manage.planet.search');
     Route::get('manage-planet/add-planet','Modules\Planets\PlanetController@addView')->name('admin.manage.planet-add-view');
     Route::post('manage-planet/check-planet','Modules\Planets\PlanetController@checkPlanet')->name('admin.manage.planet-check');
     Route::post('manage-planet/register-planet','Modules\Planets\PlanetController@addPlanet')->name('admin.manage.planet-add');
     Route::get('manage-planet/edit-planet/{id}','Modules\Planets\PlanetController@editView')->name('admin.manage.planet-edit-view');
     Route::post('manage-planet/update-planet','Modules\Planets\PlanetController@updatePlanet')->name('admin.manage.planet-update');
      Route::get('manage-planet/delete-planet/{id}','Modules\Planets\PlanetController@deletPlanet')->name('admin.manage.planet-delete');
      // manage-purpose
       Route::get('manage-purpose','Modules\Purpose\PurposeController@index')->name('admin.manage.purpose');
       Route::post('manage-purpose','Modules\Purpose\PurposeController@index')->name('admin.manage.purpose.search');
       Route::get('manage-purpose/add-purpose','Modules\Purpose\PurposeController@addView')->name('admin.manage.purpose-add-view');
       Route::post('manage-purpose/register-purpose','Modules\Purpose\PurposeController@addPurpose')->name('admin.manage.purpose-add');
       Route::post('manage-purpose/check-purpose','Modules\Purpose\PurposeController@checkPurpose')->name('admin.manage.purpose-check');
       Route::get('manage-purpose/edit-purpose/{id}','Modules\Purpose\PurposeController@editView')->name('admin.manage.purpose-edit-view');
       Route::post('manage-purpose/update-purpose','Modules\Purpose\PurposeController@updatePurpose')->name('admin.manage.purpose-update');
       Route::get('manage-purpose/delete/{id}','Modules\Purpose\PurposeController@delPurpose')->name('admin.manage.purpose.delete');


       // manage-zip-code
       Route::get('manage-zip-code','Modules\ZipMaster\ZipMasterController@index')->name('admin.manage.zip');
       Route::post('manage-zip-code','Modules\ZipMaster\ZipMasterController@index')->name('admin.manage.zip.search');
       Route::get('manage-zip-code/add','Modules\ZipMaster\ZipMasterController@addView')->name('admin.add.zip.view');
       Route::post('manage-zip-code/register','Modules\ZipMaster\ZipMasterController@addZip')->name('admin.add.zip.code');

       Route::get('manage-zip-code/edit/{id}','Modules\ZipMaster\ZipMasterController@editView')->name('admin.zip.edit.view');
       Route::post('manage-zip-code/update-zip','Modules\ZipMaster\ZipMasterController@updateZip')->name('admin.zip.update');
       Route::get('manage-zip-code/delete/{id}','Modules\ZipMaster\ZipMasterController@deleteZip')->name('admin.zip.delete');
       Route::post('manage-zip-code/import-excel', 'Modules\ZipMaster\ZipMasterController@import')->name('admin.zip.import');
       Route::get('manage-zip-code/check-zipcode','Modules\ZipMaster\ZipMasterController@checkZipcode')->name('admin.zipcode.check.zipcode');

       Route::post('manage-zip-code/get-state','Modules\ZipMaster\ZipMasterController@getState')->name('admin.manage.zipcode.get.state');
       Route::post('manage-zip-code/get-city','Modules\ZipMaster\ZipMasterController@getCity')->name('admin.manage.zipcode.get.city');
       Route::get('manage-zip-code/check-duplicate-postcode','Modules\ZipMaster\ZipMasterController@checkDuplicatePostcode')->name('admin.manage.zipcode.check.postcode');
       Route::get('manage-zip-code/upload-postcode','Modules\ZipMaster\ZipMasterController@uploadZipcodeExcel')->name('admin.manage.zipcode.upload');
       Route::post('manage-zip-code/export-postcode','Modules\ZipMaster\ZipMasterController@exportPostcode')->name('admin.manage.zipcode.export');

       //Area
       Route::get('manage-area','Modules\Area\AreaController@index')->name('admin.manage.area');
       Route::get('manage-area/add','Modules\Area\AreaController@addView')->name('admin.add.area.add');
       Route::post('manage-area/insert','Modules\Area\AreaController@addArea')->name('admin.manage.area.insert');
       Route::get('manage-area/edit/{id}','Modules\Area\AreaController@editView')->name('admin.manage.area.edit');
       Route::post('manage-area/update','Modules\Area\AreaController@editArea')->name('admin.manage.area.update');
       Route::get('manage-area/check-duplicate-area','Modules\Area\AreaController@checkDuplicateArea')->name('admin.check.area');
       Route::post('manage-area/get-state','Modules\Area\AreaController@getState')->name('admin.manage.area.get.state');
       Route::post('manage-area/get-city','Modules\Area\AreaController@getCity')->name('admin.manage.area.get.city');
       Route::post('manage-area/get-pincode','Modules\Area\AreaController@getPostcode')->name('admin.manage.area.get.area');
       Route::get('manage-area/delete-area/{id}','Modules\Area\AreaController@deleteArea')->name('admin.delete.area');
       // manage-puja-category
       Route::get('manage-puja-category','Modules\PujaCategory\PujaCategoryController@index')->name('admin.manage.puja-category');
        Route::post('manage-puja-category','Modules\PujaCategory\PujaCategoryController@index')->name('admin.manage.puja-category.search');
       Route::get('manage-puja-category/add','Modules\PujaCategory\PujaCategoryController@addView')->name('admin.manage.add-puja-category-view');
       Route::post('manage-puja-category/register','Modules\PujaCategory\PujaCategoryController@addPujaCat')->name('admin.manage.add-puja-category');
       Route::post('manage-puja-category/check','Modules\PujaCategory\PujaCategoryController@check')->name('admin.manage.check-puja-category');
       Route::get('manage-puja-category/edit/{id}','Modules\PujaCategory\PujaCategoryController@editView')->name('admin.manage.edit.puja-category');
       Route::post('manage-puja-category/update','Modules\PujaCategory\PujaCategoryController@updateCat')->name('admin.manage.update-puja-category');
       Route::get('manage-puja-category/delete/{id}','Modules\PujaCategory\PujaCategoryController@deletePuja')->name('admin.manage.puja-category-delete');
       Route::get('manage-puja-category/sub-category/add','Modules\PujaCategory\PujaCategoryController@subCatAddView')->name('admin.manage.puja.subcategory.add-view');
       Route::get('manage-puja-category/check-sub-category','Modules\PujaCategory\PujaCategoryController@subCatCheck')->name('admin.manage.puja.subcategory.check-name');
       Route::post('manage-puja-category/insert-sub-category','Modules\PujaCategory\PujaCategoryController@subCatAdd')->name('admin.manage.puja.subcategory.insert');
       Route::post('manage-puja-category/update-sub-category','Modules\PujaCategory\PujaCategoryController@subCatUpdate')->name('admin.manage.puja.subcategory.update');
       Route::post('manage-puja-category/delete-image','Modules\PujaCategory\PujaCategoryController@deleteImage')->name('admin.manage.puja.category.delete.image');

       // manage-seller-master
       Route::get('manage-seller','Modules\ManageSellerMaster\ManageSellerMasterController@index')->name('admin.manage.selelr-master');
       Route::post('manage-seller','Modules\ManageSellerMaster\ManageSellerMasterController@index')->name('admin.manage.selelr-master.search');
       Route::get('manage-seller/add-seller','Modules\ManageSellerMaster\ManageSellerMasterController@addView')->name('admin.manage.seller-master-add-view');
       Route::post('manage-seller/register-seller','Modules\ManageSellerMaster\ManageSellerMasterController@registerSeller')->name('admin.manage.seller-master-add');
       Route::get('manage-seller/edit/{id}','Modules\ManageSellerMaster\ManageSellerMasterController@editView')->name('admin.manage.seller-master-edit-view');
       Route::post('manage-seller/update','Modules\ManageSellerMaster\ManageSellerMasterController@updateSeller')->name('admin.manage.seller-master-update');
       Route::get('manage-seller/delete/{id}','Modules\ManageSellerMaster\ManageSellerMasterController@deleteSeller')->name('admin.manage.seller-master-delete');


       // manage-puja-order
       Route::get('manage-puja-order','Modules\ManagePujaOrder\ManagePujaOrderController@index')->name('admin.manage.puja.order');
       Route::post('manage-puja-order','Modules\ManagePujaOrder\ManagePujaOrderController@index')->name('admin.manage.puja.order.search');
       Route::get('manage-puja-order/assign-pundit/list','Modules\ManagePujaOrder\ManagePujaOrderController@punditList')->name('admin.manage.puja.pundit-assign-list');
       Route::post('manage-puja-order/assign-pundit','Modules\ManagePujaOrder\ManagePujaOrderController@assignPundit')->name('admin.manage.puja.assign-pundit');
       Route::get('manage-puja-order/view/{id}','Modules\ManagePujaOrder\ManagePujaOrderController@viewOrderPuja')->name('admin.manage.puja.order-view');
       Route::post('manage-puja-order/assign-customer-link','Modules\ManagePujaOrder\ManagePujaOrderController@assignLink')->name('admin.manage.puja.order-assign-puja-link');
	   Route::post('manage-puja/puja-duplicate','Modules\Puja\PujaController@pujaCodeDuplicate')->name('admin.check.puja.code');








       Route::any('manage-product-order','Modules\ManageProductOrder\ManageProductOrder@index')->name('admin.manage.product.order');
       Route::any('manage-product-order/view-details/{slug}','Modules\ManageProductOrder\ManageProductOrder@viewDetails')->name('admin.manage.product.order.view');
       Route::get('manage-product-order/change-status/{slug}/{status}','Modules\ManageProductOrder\ManageProductOrder@orderStatusChange')->name('admin.manage.product.order.status.changed');
	   Route::get('gemstone-admin-more-info', 'Modules\ManageProductOrder\ManageProductOrder@gemstoneOrderMoreInfo')->name('gemstone.admin.more.info');


       // manage-mantra
       Route::get('manage-mantra','Modules\ManageMantra\ManageMantraController@index')->name('admin.manage.mantra');
       Route::post('manage-mantra','Modules\ManageMantra\ManageMantraController@index')->name('admin.manage.mantra');
       Route::get('manage-mantra/add-mantra','Modules\ManageMantra\ManageMantraController@addView')->name('admin.manage.mantra-add-view');
       Route::post('manage-mantra/insert-mantra','Modules\ManageMantra\ManageMantraController@add')->name('admin.manage.mantra.insert');
	   Route::get('manage-mantra/edit-mantra/{id}','Modules\ManageMantra\ManageMantraController@editView')->name('admin.manage.mantra-edit-view');
		Route::post('manage-mantra/update-mantra','Modules\ManageMantra\ManageMantraController@updateMantra')->name('admin.manage.mantra-update');
      Route::get('manage-mantra/delete-mantra/{id}','Modules\ManageMantra\ManageMantraController@deletMantra')->name('admin.manage.mantra-delete');
      Route::get('manage-mantra/delete-mantra-price/{id}','Modules\ManageMantra\ManageMantraController@deletMantraPrice')->name('admin.manage.mantra-price-delete');








      // manage-ring-size-system
      Route::get('manage-ring-size-system','Modules\RingSystem\RingSystemController@index')->name('admin.manage.ring.system');
      Route::post('manage-ring-size-system','Modules\RingSystem\RingSystemController@index')->name('admin.manage.ring.system.search');
      Route::get('manage-ring-size-system/add','Modules\RingSystem\RingSystemController@addView')->name('admin.manage.ring.add.view');
      Route::post('manage-ring-size-system/check-name','Modules\RingSystem\RingSystemController@check')->name('admin.manage.ring.system-check');
      Route::post('manage-ring-size-system/add-name','Modules\RingSystem\RingSystemController@add')->name('admin.manage.ring.system.add');
      Route::get('manage-ring-size-system/delete/{id}','Modules\RingSystem\RingSystemController@delete')->name('admin.manage.ring.system-delete');
      Route::get('manage-ring-size-system/edit/{id}','Modules\RingSystem\RingSystemController@edit')->name('admin.manage.ring.system-edit-view');
      Route::post('manage-ring-size-system/update','Modules\RingSystem\RingSystemController@update')->name('admin.manage.ring.system-update');

      // manange-ring-size
      Route::get('manage-ring-size','Modules\RingSize\RingSizeController@index')->name('admin.manage.ring.size');
      Route::post('manage-ring-size','Modules\RingSize\RingSizeController@index')->name('admin.manage.ring.size.search');
      Route::get('manage-ring-size/add','Modules\RingSize\RingSizeController@addView')->name('admin.manage.ring.size.add-view');
      Route::post('manage-ring-size/insert','Modules\RingSize\RingSizeController@add')->name('admin.manage.ring.size.add');
      Route::get('manage-ring-size/check','Modules\RingSize\RingSizeController@check')->name('admin.manage.ring.size.check');
      Route::get('manage-ring-size/delete/{id}','Modules\RingSize\RingSizeController@delete')->name('admin.manage.ring.size.delete');
      Route::get('manage-ring-size/edit/{id}','Modules\RingSize\RingSizeController@edit')->name('admin.manage.ring.size.edit');
      Route::post('manage-ring-size/update','Modules\RingSize\RingSizeController@update')->name('admin.manage.ring.size.update');

      // manage-bracelet-design
      Route::get('manage-bracelet-design','Modules\BraceletDesign\BraceletDesignController@index')->name('admin.manage.bracelet.design');
      Route::post('manage-bracelet-design','Modules\BraceletDesign\BraceletDesignController@index')->name('admin.manage.bracelet.design.search');
      Route::get('manage-bracelet-design/add','Modules\BraceletDesign\BraceletDesignController@addView')->name('admin.manage.bracelet.design.add-view');
      Route::post('manage-bracelet-design/insert','Modules\BraceletDesign\BraceletDesignController@add')->name('admin.manage.bracelet.design.add');
      Route::get('manage-bracelet-design/check','Modules\BraceletDesign\BraceletDesignController@check')->name('admin.manage.bracelet.design.check');
      Route::get('manage-bracelet-design/delete/{id}','Modules\BraceletDesign\BraceletDesignController@delete')->name('admin.manage.bracelet.design.delete');
      Route::get('manage-bracelet-design/edit/{id}','Modules\BraceletDesign\BraceletDesignController@edit')->name('admin.manage.bracelet.design.edit');
      Route::post('manage-bracelet-design/update','Modules\BraceletDesign\BraceletDesignController@update')->name('admin.manage.bracelet.design.update');

      Route::post('manage-bracelet-design/delete','Modules\BraceletDesign\BraceletDesignController@deleteImage')->name('admin.manage.bracelet.design.delete.image');

      // puja-energization
      Route::get('manage-puja-energization','Modules\PujaEnergization\PujaEnergizationController@index')->name('admin.manage.puja-energization');
      Route::post('manage-puja-energization','Modules\PujaEnergization\PujaEnergizationController@index')->name('admin.manage.puja-energization.search');
      Route::get('manage-puja-energization/add','Modules\PujaEnergization\PujaEnergizationController@addView')->name('admin.manage.puja-energization.add-view');
      Route::post('manage-puja-energization/insert','Modules\PujaEnergization\PujaEnergizationController@add')->name('admin.manage.puja-energization.add');
      Route::post('manage-puja-energization/check','Modules\PujaEnergization\PujaEnergizationController@check')->name('admin.manage.puja-energization.check');
      Route::get('manage-puja-energization/delete/{id}','Modules\PujaEnergization\PujaEnergizationController@delete')->name('admin.manage.puja-energization.delete');
      Route::get('manage-puja-energization/edit/{id}','Modules\PujaEnergization\PujaEnergizationController@editView')->name('admin.manage.puja-energization.edit-view');
      Route::post('manage-puja-energization/update','Modules\PujaEnergization\PujaEnergizationController@update')->name('admin.manage.puja-energization.update');
      Route::get('manage-puja-energization/check-price','Modules\PujaEnergization\PujaEnergizationController@checkPrice')->name('admin.manage.puja-energization.check-price');
      Route::get('manage-puja-energization/check-price-edit','Modules\PujaEnergization\PujaEnergizationController@checkPriceEdit')->name('admin.manage.puja-energization.check-price-edit');

      // cirtification
      Route::get('manage-certificate','Modules\Cirtificate\CirtificateController@index')->name('admin.manage.cirtification');
      Route::post('manage-certificate','Modules\Cirtificate\CirtificateController@index')->name('admin.manage.cirtification.search');
      Route::get('manage-certificate/add','Modules\Cirtificate\CirtificateController@addView')->name('admin.manage.cirtification.add-view');
      Route::post('manage-certificate/insert','Modules\Cirtificate\CirtificateController@add')->name('admin.manage.cirtification.add');
      Route::get('manage-certificate/check-price','Modules\Cirtificate\CirtificateController@checkPrice')->name('admin.manage.cirtification.check.price');
      Route::get('manage-certificate/edit/{id}','Modules\Cirtificate\CirtificateController@editView')->name('admin.manage.cirtification.edit-view');
      Route::get('manage-certificate/check-price-edit','Modules\Cirtificate\CirtificateController@editCheckPrice')->name('admin.manage.cirtification.check.price-edit');
      Route::post('manage-certificate/update','Modules\Cirtificate\CirtificateController@update')->name('admin.manage.cirtification.update');
      Route::get('manage-certificate/delete/{id}','Modules\Cirtificate\CirtificateController@delete')->name('admin.manage.cirtification.delete');

      // gold-purity
      Route::get('manage-gold-purity','Modules\GoldPurity\GoldPurityController@index')->name('admin.manage.gold.purity');
      Route::get('manage-gold-purity/edit/{id}','Modules\GoldPurity\GoldPurityController@editView')->name('admin.manage.gold.purity.edit');

      Route::post('manage-gold-purity/update','Modules\GoldPurity\GoldPurityController@update')->name('admin.manage.gold.purity.update');

      // ring-pendent-price
      Route::any('manage-ring-pendent-price','Modules\RingPendent\RingPendentController@index')->name('admin.manage.ring-pendent-price');
      Route::get('manage-ring-pendent-price/add','Modules\RingPendent\RingPendentController@addView')->name('admin.manage.ring-pendent-price.add-view');
     Route::post('manage-ring-pendent-price/insert','Modules\RingPendent\RingPendentController@add')->name('admin.manage.ring-pendent-price.add');
     Route::get('manage-ring-pendent-price/check','Modules\RingPendent\RingPendentController@check')->name('admin.manage.ring-pendent-price.check');
      Route::get('manage-ring-pendent-price/edit/{id}','Modules\RingPendent\RingPendentController@edit')->name('admin.manage.ring-pendent-price.edit');
      Route::post('manage-ring-pendent-price/update','Modules\RingPendent\RingPendentController@update')->name('admin.manage.ring-pendent-price.update');
      Route::get('manage-ring-pendent-price/delete/{id}','Modules\RingPendent\RingPendentController@delete')->name('admin.manage.ring-pendent-price.delete');

      // manage-treatment
      Route::any('manage-treatment','Modules\ManageTreatment\TreatmentController@index')->name('admin.manage.treatment');
      Route::get('manage-treatment/add','Modules\ManageTreatment\TreatmentController@addView')->name('admin.manage.treatment.add-view');
      Route::post('manage-treatment/insert','Modules\ManageTreatment\TreatmentController@add')->name('admin.manage.treatment.add');
      Route::post('manage-treatment/check-name','Modules\ManageTreatment\TreatmentController@check')->name('admin.manage.treatment.check');
      Route::get('manage-treatment/edit/{id}','Modules\ManageTreatment\TreatmentController@editView')->name('admin.manage.treatment.edit-view');
       Route::post('manage-treatment/update','Modules\ManageTreatment\TreatmentController@update')->name('admin.manage.treatment.update');
       Route::get('manage-treatment/delete/{id}','Modules\ManageTreatment\TreatmentController@delete')->name('admin.manage.treatment.delete');

       // manage-cirtificate-name
       Route::any('manage-cirtificate-name','Modules\CirtificateName\CirtificateNameController@index')->name('admin.manage.cirtificate.name');
       Route::get('manage-cirtificate-name/add','Modules\CirtificateName\CirtificateNameController@addView')->name('admin.manage.cirtificate.name-add-view');
       Route::post('manage-cirtificate-name/check','Modules\CirtificateName\CirtificateNameController@check')->name('admin.manage.cirtificate.name.check');
       Route::post('manage-cirtificate-name/insert','Modules\CirtificateName\CirtificateNameController@add')->name('admin.manage.cirtificate.name-insert');
       Route::get('manage-cirtificate-name/delete/{id}','Modules\CirtificateName\CirtificateNameController@delete')->name('admin.manage.cirtificate.name.delete');
       Route::get('manage-cirtificate-name/edit/{id}','Modules\CirtificateName\CirtificateNameController@editView')->name('admin.manage.cirtificate.name.edit');
       Route::post('manage-cirtificate-name/update','Modules\CirtificateName\CirtificateNameController@update')->name('admin.manage.cirtificate.name.update');

       // manage-color
       Route::any('manage-color','Modules\ManageColor\ManageColorController@index')->name('admin.manage.gemstone.color');
       Route::get('manage-color/add','Modules\ManageColor\ManageColorController@addView')->name('admin.manage.gemstone.color.add-view');
       Route::post('manage-color/check','Modules\ManageColor\ManageColorController@check')->name('admin.manage.gemstone.color.check');
       Route::post('manage-color/insert','Modules\ManageColor\ManageColorController@add')->name('admin.manage.gemstone.color.add');
       Route::get('manage-color/delete/{id}','Modules\ManageColor\ManageColorController@delete')->name('admin.manage.gemstone.color.delete');
       Route::get('manage-color/edit/{id}','Modules\ManageColor\ManageColorController@edit')->name('admin.manage.gemstone.color.edit');
       Route::post('manage-color/update','Modules\ManageColor\ManageColorController@updated')->name('admin.manage.gemstone.color.update');

       // manage-gemstone-title
       Route::any('manage-gemstone-title','Modules\ManageGemstoneTitle\ManageGemstoneTitleController@index')->name('admin.manage.gemstone.title');
       Route::get('manage-gemstone-title/add','Modules\ManageGemstoneTitle\ManageGemstoneTitleController@titleAddView')->name('admin.manage.gemstone.title.add-view');
       Route::post('manage-gemstone-title/insert','Modules\ManageGemstoneTitle\ManageGemstoneTitleController@titleAdd')->name('admin.manage.gemstone.title.add');
       Route::post('manage-gemstone-title/check','Modules\ManageGemstoneTitle\ManageGemstoneTitleController@check')->name('admin.manage.gemstone.title.check');
       Route::get('manage-gemstone-title/edit/{id}','Modules\ManageGemstoneTitle\ManageGemstoneTitleController@titleEditView')->name('admin.manage.gemstone.title.edit-view');
       Route::post('manage-gemstone-title/update','Modules\ManageGemstoneTitle\ManageGemstoneTitleController@titleUpdate')->name('admin.manage.gemstone.title.update');

       Route::post('manage-gemstone-title/delete-image','Modules\ManageGemstoneTitle\ManageGemstoneTitleController@deleteImage')->name('admin.manage.gemstone.title.image.delete');

       // manage-gemstone-sub-title
       Route::get('manage-gemstone-title/subtile/add','Modules\ManageGemstoneTitle\ManageGemstoneTitleController@subtitleAddView')->name('admin.manage.gemstone.sub-title-add-view');
       Route::post('manage-gemstone-title/subtile/insert','Modules\ManageGemstoneTitle\ManageGemstoneTitleController@subtitleAdd')->name('admin.manage.gemstone.title.sub-title-add');

       Route::get('manage-gemstone-title/subtitle/check','Modules\ManageGemstoneTitle\ManageGemstoneTitleController@subtitleCheck')->name('admin.manage.gemstone.subtitle.check.name');

       Route::post('manage-gemstone-title/subtile/update','Modules\ManageGemstoneTitle\ManageGemstoneTitleController@subtitleUpdate')->name('admin.manage.gemstone.title.sub-title-update');

       Route::get('manage-gemstone-title/delete/{id}','Modules\ManageGemstoneTitle\ManageGemstoneTitleController@delete')->name('admin.manage.gemstone.title.delete');


       // manage-ring-pendent-design
       Route::any('manage-ring-pendent-design','Modules\RingPendentDesign\RingPendentDesignController@index')->name('admin.manage.ring.pendent.design');
       Route::get('manage-ring-pendent-design/add','Modules\RingPendentDesign\RingPendentDesignController@addView')->name('admin.manage.ring.pendent.design.add-view');
       Route::get('manage-ring-pendent-design/check','Modules\RingPendentDesign\RingPendentDesignController@check')->name('admin.manage.ring.pendent.design.check');
       Route::post('manage-ring-pendent-design/insert','Modules\RingPendentDesign\RingPendentDesignController@add')->name('admin.manage.ring.pendent.design.add');
       Route::get('manage-ring-pendent-design/delete/{id}','Modules\RingPendentDesign\RingPendentDesignController@delete')->name('admin.manage.ring.pendent.design.delete');
       Route::get('manage-ring-pendent-design/edit/{id}','Modules\RingPendentDesign\RingPendentDesignController@editView')->name('admin.manage.ring.pendent.design.edit');
       Route::post('manage-ring-pendent-design/update','Modules\RingPendentDesign\RingPendentDesignController@update')->name('admin.manage.ring.pendent.design.update');

       Route::post('manage-ring-pendent-design/delete-image','Modules\RingPendentDesign\RingPendentDesignController@deleteImage')->name('admin.manage.ring.pendent.design.delete.image');

       // manage-faq-category
       Route::any('manage-faq-category','Modules\FaqCategory\FaqCategoryController@index')->name('admin.manage.faq.category');
       Route::get('manage-faq-category/add-category','Modules\FaqCategory\FaqCategoryController@addCatView')->name('admin.manage.faq.category.add-view');
       Route::post('manage-faq-category/insert-category','Modules\FaqCategory\FaqCategoryController@addCat')->name('admin.manage.faq.category.add');

        Route::post('manage-faq-category/check-category','Modules\FaqCategory\FaqCategoryController@checkCat')->name('admin.manage.faq.category.check');
        Route::get('manage-faq-category/delete/{id}','Modules\FaqCategory\FaqCategoryController@delete')->name('admin.manage.faq.category.delete');
        Route::get('manage-faq-category/edit/{id}','Modules\FaqCategory\FaqCategoryController@editView')->name('admin.manage.faq.category.edit');
        Route::post('manage-faq-category/update/category','Modules\FaqCategory\FaqCategoryController@updateCat')->name('admin.manage.faq.category.update');



        Route::get('manage-faq-category/add-sub-category','Modules\FaqCategory\FaqCategoryController@addSubCatView')->name('admin.manage.faq.subcategory.addview');
         Route::get('manage-faq-category/check-sub-category','Modules\FaqCategory\FaqCategoryController@checkSubCat')->name('admin.manage.faq.subcategory.check');
         Route::post('manage-faq-category/insert-sub-category','Modules\FaqCategory\FaqCategoryController@insertSubCategoy')->name('admin.manage.faq.subcategory.insert');
         Route::post('manage-faq-category/update-sub-category','Modules\FaqCategory\FaqCategoryController@updateSubCategoy')->name('admin.manage.faq.subcategory.update');





       // manage-faq
       Route::any('manage-general-faq','Modules\Faq\FaqController@index')->name('admin.manage.general.faq');
       Route::get('manage-general-faq/add','Modules\Faq\FaqController@addView')->name('admin.manage.general.faq.add.view');
       Route::post('manage-general-faq/insert','Modules\Faq\FaqController@add')->name('admin.manage.general.faq.add');
       Route::get('manage-general-faq/delete/{id}','Modules\Faq\FaqController@delete')->name('admin.manage.general.faq.delete');
       Route::get('manage-general-faq/edit/{id}','Modules\Faq\FaqController@editView')->name('admin.manage.general.faq.edit');
       Route::post('manage-general-faq/update','Modules\Faq\FaqController@update')->name('admin.manage.general.faq.update');
       Route::get('manage-general-faq/get-sub-category','Modules\Faq\FaqController@getsubcat')->name('admin.manage.general.faq.get-sub-category');
       Route::get('manage-general-faq/show-on-search/{id}','Modules\Faq\FaqController@showSearch')->name('admin.manage.general.faq.show-on-search');

       Route::get('manage-general-faq/check-display-order','Modules\Faq\FaqController@checkDisplay')->name('admin.manage.check.display.order');

       // individual-faq
       // faq-puja
       Route::any('manage-puja-faq/{id}','Modules\Faq\FaqController@manageFaqPuja')->name('admin.manage.faq.puja');
       Route::get('manage-puja-faq/add/{id}','Modules\Faq\FaqController@manageFaqPujaAddView')->name('admin.manage.faq.puja.add-view');
       Route::post('manage-faq/add','Modules\Faq\FaqController@addFaq')->name('admin.manage.faq.add');
       Route::get('manage-puja-faq/edit/{faq}','Modules\Faq\FaqController@manageFaqPuja_edit')->name('admin.manage.faq.puja.edit-view');
        Route::post('manage-faq/update','Modules\Faq\FaqController@updateFaq')->name('admin.manage.faq.update');
       Route::get('manage-faq/delete/{id}','Modules\Faq\FaqController@deleteFaq')->name('admin.manage.faq.delete');
        // add-from-general-faq
        Route::any('manage-puja-faq/add-from-general-faq/{id}','Modules\Faq\FaqController@manageFaqPuja_generalview')->name('admin.manage.faq.puja.genral.faq.view');
        Route::post('manage-puja-faq/add-general-faq-puja/add','Modules\Faq\FaqController@addPuja_generalfaq')->name('admin.manage.faq.puja.genral.faq.add');


       // faq-gamestone
       Route::any('manage-gamestone-faq/{id}','Modules\Faq\FaqController@manageFaqGamestone')->name('admin.manage.faq.gamestone');
       Route::get('manage-gamestone-faq/add/{id}','Modules\Faq\FaqController@manageFaqGemsAddView')->name('admin.manage.faq.gamestone.add-view');
       Route::get('manage-gamestone-faq/edit/{faq}','Modules\Faq\FaqController@manageFaqGames_edit')->name('admin.manage.faq.gamestone.edit-view');
       // add-from-general-faq
       Route::any('manage-gamestone-faq/add-from-general-faq/{id}','Modules\Faq\FaqController@manageFaqGems_generalview')->name('admin.manage.faq.gamestone.genral.faq.view');

       Route::post('manage-gamestone-faq/add-general-faq-gamestone/add','Modules\Faq\FaqController@addGamestone_generalfaq')->name('admin.manage.faq.gamestone.genral.faq.add');

       // faq-product
       Route::any('manage-product-faq/{id}','Modules\Faq\FaqController@manageFaqProduct')->name('admin.manage.faq.product');
       Route::get('manage-product-faq/add/{id}','Modules\Faq\FaqController@manageFaqProAddView')->name('admin.manage.faq.product.add-view');
       Route::get('manage-product-faq/edit/{faq}','Modules\Faq\FaqController@manageFaqGames_edit')->name('admin.manage.faq.product.edit-view');
       // add-from-general-faq
       Route::any('manage-product-faq/add-from-general-faq/add/{id}','Modules\Faq\FaqController@manageFaqProduct_generalview')->name('admin.manage.faq.product.genral.faq.view');

       // manage-puja-name
       Route::any('manage-puja-name','Modules\PujaName\PujaNameController@index')->name('admin.manage.puja.name');
       Route::get('manage-puja-name/add','Modules\PujaName\PujaNameController@addView')->name('admin.manage.puja.name.add');
       Route::post('manage-puja-name/insert','Modules\PujaName\PujaNameController@add')->name('admin.manage.puja.name.insert');
       Route::post('manage-puja-name/check','Modules\PujaName\PujaNameController@check')->name('admin.manage.puja.name.check');
       Route::get('manage-puja-name/delete/{id}','Modules\PujaName\PujaNameController@delete')->name('admin.manage.puja.name.delete');
       Route::get('manage-puja-name/edit/{id}','Modules\PujaName\PujaNameController@editView')->name('admin.manage.puja.name.edit');
       Route::post('manage-puja-name/update','Modules\PujaName\PujaNameController@update')->name('admin.manage.puja.name.update');
       Route::post('manage-puja-name/delete-image','Modules\PujaName\PujaNameController@deleteImage')->name('admin.manage.puja.name.delete.image');


       // search-page-data
       Route::get('manage-search-page-data','Modules\SearchPageData\SearchPageDataController@index')->name('admin.manage.search.page.data');
       Route::get('manage-search-page-data/edit-data/{id}','Modules\SearchPageData\SearchPageDataController@edit')->name('admin.manage.search.page.data-edit-view');
       Route::post('manage-search-page-data/update','Modules\SearchPageData\SearchPageDataController@update')->name('admin.manage.search.page.data.update');
       Route::any('edit-why-who','Modules\SearchPageData\SearchPageDataController@editwhyWho')->name('admin.edit.why.who');

       // home-page-banner
       Route::get('manage-home-page-bannner','Modules\ManageBanner\ManageBannerController@index')->name('admin.manage.home.page.banner');
       Route::post('manage-home-page-bannner/save-settings','Modules\ManageBanner\ManageBannerController@updateSettings')->name('admin.manage.home.page.banner.save.settings');
       Route::post('manage-home-page-bannner/banner-upload','Modules\ManageBanner\ManageBannerController@videoUpload')->name('admin.manage.home.page.banner.video-upload');

       // Route::get('manage-home-page-bannner/update-settings','Modules\ManageBanner\ManageBannerController@updateSettings')->name('admin.manage.home.page.banner.update-settings');

       Route::get('manage-home-page-bannner/update-transition','Modules\ManageBanner\ManageBannerController@updateTransition')->name('admin.manage.home.page.banner.update-transition');

       Route::get('manage-home-page-bannner/add-banner-image','Modules\ManageBanner\ManageBannerController@addImageView')->name('admin.manage.home.page.banner.add-image');

       Route::post('manage-home-page-bannner/add-banner-image','Modules\ManageBanner\ManageBannerController@addImage')->name('admin.manage.home.page.banner.insert-image');

       Route::get('manage-home-page-bannner/delete-banner-image/{id}','Modules\ManageBanner\ManageBannerController@deleteImage')->name('admin.manage.home.page.banner.delete');

       Route::get('manage-home-page-bannner/edit-banner-image/{id}','Modules\ManageBanner\ManageBannerController@editView')->name('admin.manage.home.page.banner.edit');

       Route::post('manage-home-page-bannner/update-banner-image','Modules\ManageBanner\ManageBannerController@updateImage')->name('admin.manage.home.page.banner.update');



       // home-page-banner-second-slider
       Route::get('home-page-banner-second-slider','Modules\SecondBanner\SecondBannerController@index')->name('admin.manage.home.page.banner.second');

       Route::post('home-page-banner-second-slider/save-settings','Modules\SecondBanner\SecondBannerController@updateSettings')->name('admin.manage.home.page.banner.save.settings.second');

       Route::post('home-page-banner-second-slider/banner-upload','Modules\SecondBanner\SecondBannerController@videoUpload')->name('admin.manage.home.page.banner.video-upload.second');

       Route::get('home-page-banner-second-slider/add-banner-image','Modules\SecondBanner\SecondBannerController@addImageView')->name('admin.manage.home.page.banner.add-image.second');

       Route::post('home-page-banner-second-slider/add-banner-image','Modules\SecondBanner\SecondBannerController@addImage')->name('admin.manage.home.page.banner.insert-image.second');

       Route::get('home-page-banner-second-slider/delete-banner-image/{id}','Modules\SecondBanner\SecondBannerController@deleteImage')->name('admin.manage.home.page.banner.delete.second');

       Route::get('home-page-banner-second-slider/edit-banner-image/{id}','Modules\SecondBanner\SecondBannerController@editView')->name('admin.manage.home.page.banner.edit.second');

       Route::post('home-page-banner-second-slider/update-banner-image','Modules\SecondBanner\SecondBannerController@updateImage')->name('admin.manage.home.page.banner.update.second');

       // manage-horoscope-category
       Route::any('manage-horoscope-category','Modules\HoroscopeCategory\HoroscopeCategoryController@index')->name('admin.modules.manage.horoscope.category');
       Route::get('manage-horoscope-category/add-category','Modules\HoroscopeCategory\HoroscopeCategoryController@addView')->name('admin.modules.manage.horoscope.category.addview');
       Route::post('manage-horoscope-category/check','Modules\HoroscopeCategory\HoroscopeCategoryController@check')->name('admin.modules.manage.horoscope.category.check');
       Route::post('manage-horoscope-category/insert','Modules\HoroscopeCategory\HoroscopeCategoryController@add')->name('admin.modules.manage.horoscope.category.insert');
       Route::get('manage-horoscope-category/delete-category/{id}','Modules\HoroscopeCategory\HoroscopeCategoryController@delete')->name('admin.modules.manage.horoscope.category.delete');
       Route::get('manage-horoscope-category/edit-category/{id}','Modules\HoroscopeCategory\HoroscopeCategoryController@edit')->name('admin.modules.manage.horoscope.category.edit-view');
       Route::post('manage-horoscope-category/update-category','Modules\HoroscopeCategory\HoroscopeCategoryController@update')->name('admin.modules.manage.horoscope.category.update');


       Route::get('manage-horoscope-category/add-sub-category','Modules\HoroscopeCategory\HoroscopeCategoryController@addSubCategory')->name('admin.modules.manage.horoscope.sub-cat-add');

       Route::post('manage-horoscope-category/insert-sub-category','Modules\HoroscopeCategory\HoroscopeCategoryController@insertSubCategory')->name('admin.modules.manage.horoscope.sub-category.insert');

       Route::post('manage-horoscope-category/update-sub-category','Modules\HoroscopeCategory\HoroscopeCategoryController@updateSubCategory')->name('admin.modules.manage.horoscope.sub-category.update');

       Route::get('manage-horoscope-category/check-sub-category','Modules\HoroscopeCategory\HoroscopeCategoryController@checkSubCategory')->name('admin.modules.manage.horoscope.sub-category.check');

       Route::post('manage-horoscope-category/delete-image','Modules\HoroscopeCategory\HoroscopeCategoryController@deleteImage')->name('admin.hororscope.category.delete.image');
      // manage-horoscope-title
      Route::any('manage-horoscope-title','Modules\HoroscopeTitle\HoroscopeTitleController@index')->name('admin.manage.horoscope.title');
      Route::get('manage-horoscope-title/add-title','Modules\HoroscopeTitle\HoroscopeTitleController@addView')->name('admin.manage.horoscope.title.add-view');
      Route::post('manage-horoscope-title/insert-title','Modules\HoroscopeTitle\HoroscopeTitleController@add')->name('admin.manage.horoscope.title.add');
      Route::post('manage-horoscope-title/check-title','Modules\HoroscopeTitle\HoroscopeTitleController@check')->name('admin.manage.horoscope.title.check');
      Route::get('manage-horoscope-title/edit-title/{id}','Modules\HoroscopeTitle\HoroscopeTitleController@editView')->name('admin.manage.horoscope.title.edit-view');
      Route::post('manage-horoscope-title/update-title','Modules\HoroscopeTitle\HoroscopeTitleController@update')->name('admin.manage.horoscope.title.update');
      Route::get('manage-horoscope-title/delete-title/{id}','Modules\HoroscopeTitle\HoroscopeTitleController@delete')->name('admin.manage.horoscope.title.delete');
      Route::post('manage-horoscope-title/delete-image','Modules\HoroscopeTitle\HoroscopeTitleController@deleteImage')->name('admin.hororscope.title.delete.image');


      // manage-horoscope
      Route::any('manage-horoscope','Modules\ManageHoroscope\ManageHoroscopeController@index')->name('admin.manage.horoscope');
      Route::get('manage-horoscope/add','Modules\ManageHoroscope\ManageHoroscopeController@addView')->name('admin.manage.horoscope.add-view');
      Route::post('manage-horoscope/add','Modules\ManageHoroscope\ManageHoroscopeController@add')->name('admin.manage.horoscope.add');
      Route::post('manage-horoscope/check-code','Modules\ManageHoroscope\ManageHoroscopeController@checkCode')->name('admin.manage.horoscope.check.code');
      Route::get('manage-horoscope/change-status/{id}','Modules\ManageHoroscope\ManageHoroscopeController@changeStatus')->name('admin.manage.horoscope.status.change');
      Route::get('manage-horoscope/delete/{id}','Modules\ManageHoroscope\ManageHoroscopeController@delete')->name('admin.manage.horoscope.status.delete');
      Route::get('manage-horoscope/edit/{id}','Modules\ManageHoroscope\ManageHoroscopeController@edit')->name('admin.manage.horoscope.edit-view');
      Route::post('manage-horoscope/update','Modules\ManageHoroscope\ManageHoroscopeController@update')->name('admin.manage.horoscope.update');

      Route::get('manage-horoscope/get-sub-category','Modules\ManageHoroscope\ManageHoroscopeController@getSubCategory')->name('admin.manage.horoscope.get-sub-category');
      // faq
      Route::get('manage-horoscope/manage-faq/{id}','Modules\Faq\FaqController@manageHoroscopeFaq')->name('admin.manage.horoscope.faq');
      Route::get('manage-horoscope/manage-faq/add/{id}','Modules\Faq\FaqController@manageHoroscopeFaqAddview')->name('admin.manage.horoscope.faq.add');
      Route::get('manage-horoscope/manage-faq/edit/{faq}','Modules\Faq\FaqController@manageHoroscopeFaqEdit')->name('admin.manage.horoscope.faq.edit');
      // general-faq
      Route::any('manage-horoscope/add-from-general-faq/{id}','Modules\Faq\FaqController@horoscopeGeneral')->name('admin.manage.horoscope.add.general.faq');

      Route::post('manage-horoscope/add-general-faq-gamestone/add','Modules\Faq\FaqController@horoscopeGeneralAdd')->name('admin.manage.faq.horoscope.genral.faq.add');

      Route::post('manage-horoscope/delete-image','Modules\ManageHoroscope\ManageHoroscopeController@deleteImage')->name('admin.manage.horoscope.delete.image');

      //Aquilia Wiki

      Route::get('manage-aquilia-wiki/add-aquilia-wiki','Modules\ManageAquiliaWiki\ManageAquiliaWikiController@addAquiliaWiki')->name('admin.add.aquilia.wiki');
      Route::get('get-wiki-subcategorhy','Modules\ManageAquiliaWiki\ManageAquiliaWikiController@getSubcategory')->name('admin.wiki.subcat');
      Route::post('manage-aquilia-wiki/insert-aquilia-wiki','Modules\ManageAquiliaWiki\ManageAquiliaWikiController@insertAquiliaWiki')->name('admin.insert.aquilia.wiki');
      Route::get('manage-aquilia-wiki/edit-aquilia-wiki/{id}','Modules\ManageAquiliaWiki\ManageAquiliaWikiController@addAquiliaWiki')->name('admin.edit.aquilia.wiki');
      Route::post('manage-aquilia-wiki/update-aquilia-wiki','Modules\ManageAquiliaWiki\ManageAquiliaWikiController@insertAquiliaWiki')->name('admin.update.aquilia.wiki');
      Route::get('manage-aquilia-wiki/delete-aquilia-wiki','Modules\ManageAquiliaWiki\ManageAquiliaWikiController@deleteWiki')->name('admin.delete.aquilia.wiki');
      Route::get('manage-aquilia-wiki/wiki-list','Modules\ManageAquiliaWiki\ManageAquiliaWikiController@index')->name('admin.manage.aquilia.wiki');
      Route::post('manage-aquilia-wiki/delete-aquilia-wiki-image','Modules\ManageAquiliaWiki\ManageAquiliaWikiController@deleteWikiImage')->name('admin.delete.aquilia.wiki.image');
      Route::post('manage-aquilia-wiki/delete-aquilia-wiki-pdf','Modules\ManageAquiliaWiki\ManageAquiliaWikiController@deleteWikiPdf')->name('admin.delete.aquilia.wiki.pdf');
      // manage-horoscope-order
      Route::any('manage-horoscope-order','Modules\HoroscopeOrder\HoroscopeOrderController@index')->name('admin.manage.horoscope.order');
      Route::get('manage-horoscope-order/cancel-order/{id}','Modules\HoroscopeOrder\HoroscopeOrderController@cancel')->name('admin.manage.horoscope.order.cancel');
      Route::get('manage-horoscope-order/view-order/{id}','Modules\HoroscopeOrder\HoroscopeOrderController@view')->name('admin.manage.horoscope.order.view');


      // manage-data-bank

      Route::any('manage-data-bank','Modules\DataBank\DataBankController@index')->name('admin.manage.data.bank');
      Route::get('manage-data-bank/add','Modules\DataBank\DataBankController@addView')->name('admin.manage.data.bank.add-view');

      Route::post('manage-data-bank/check-famous','Modules\DataBank\DataBankController@famous')->name('admin.manage.data.bank.check-famous');

      Route::post('manage-data-bank/check-profession','Modules\DataBank\DataBankController@profession')->name('admin.manage.data.bank.check-profession');

      Route::post('manage-data-bank/insert','Modules\DataBank\DataBankController@add')->name('admin.manage.data.bank.add');
      Route::get('manage-data-bank/get-state','Modules\DataBank\DataBankController@getState')->name('admin.manage.data-bank.get-state');
      Route::get('manage-data-bank/get-city','Modules\DataBank\DataBankController@getCity')->name('admin.manage.data-bank.get-city');
      Route::get('manage-data-bank/delete/{id}','Modules\DataBank\DataBankController@delete')->name('admin.manage.data.bank.delete');
      Route::get('manage-data-bank/edit/{id}','Modules\DataBank\DataBankController@edit')->name('admin.manage.data.bank.edit');
      Route::post('manage-data-bank/update','Modules\DataBank\DataBankController@update')->name('admin.manage.data.bank.update');
      Route::get('manage-data-bank/download-pdf/{file?}','Modules\DataBank\DataBankController@download')->name('admin.manage.data.bank.download.pdf');

      Route::post('manage-data-bank/delete-pdf','Modules\DataBank\DataBankController@deletePdf')->name('admin.manage.data.bank.delete.pdf');

      Route::post('manage-data-bank/delete-image','Modules\DataBank\DataBankController@deleteImage')->name('admin.manage.data.bank.delete.image');


      // manage-wiki-category
      Route::any('manage-wiki-category','Modules\WikiCategory\WikiCategoryController@index')->name('admin.manage.wiki.category');
      Route::get('manage-wiki-category/add-category','Modules\WikiCategory\WikiCategoryController@addView')->name('admin.manage.wiki.category.add-view');
      Route::post('manage-wiki-category/check-category','Modules\WikiCategory\WikiCategoryController@check')->name('admin.manage.wiki.category.check');
      Route::post('manage-wiki-category/insert-category','Modules\WikiCategory\WikiCategoryController@add')->name('admin.manage.wiki.category.add');
      Route::get('manage-wiki-category/edit-category/{id}','Modules\WikiCategory\WikiCategoryController@editView')->name('admin.manage.wiki.category.edit-view');
      Route::post('manage-wiki-category/update-category-main','Modules\WikiCategory\WikiCategoryController@updateCat')->name('admin.manage.wiki.category.update');
      Route::get('manage-wiki-category/delete-category/{id}','Modules\WikiCategory\WikiCategoryController@delete')->name('admin.manage.wiki.category.delete');
      Route::get('manage-wiki-category/add-sub-category','Modules\WikiCategory\WikiCategoryController@addSubCatView')->name('admin.manage.wiki.sub-category.add-view');
      Route::get('manage-wiki-category/check-sub-category','Modules\WikiCategory\WikiCategoryController@checkSub')->name('admin.manage.wiki.sub-category.check');
      Route::post('manage-wiki-category/insert-sub-category','Modules\WikiCategory\WikiCategoryController@insertSubCategory')->name('admin.manage.wiki.sub-category.insert');
      Route::post('manage-wiki-category/update-category','Modules\WikiCategory\WikiCategoryController@updateSubCategory')->name('admin.manage.wiki.sub-category.update');

      Route::post('manage-wiki-category/delete-image','Modules\WikiCategory\WikiCategoryController@deleteImage')->name('admin.manage.wiki.delete.image');

      // manage-wiki-title
      Route::any('manage-wiki-title','Modules\WikiTitle\WikiTitleController@index')->name('admin.manage.wiki.title');
      Route::get('manage-wiki-title/add-title','Modules\WikiTitle\WikiTitleController@addView')->name('admin.manage.wiki.title.add-view');
      Route::post('manage-wiki-title/insert-title','Modules\WikiTitle\WikiTitleController@add')->name('admin.manage.wiki.title.insert');
      Route::post('manage-wiki-title/check-title','Modules\WikiTitle\WikiTitleController@check')->name('admin.manage.wiki.title.check');
      Route::get('manage-wiki-title/delete-title/{id}','Modules\WikiTitle\WikiTitleController@delete')->name('admin.manage.wiki.title.delete');
      Route::get('manage-wiki-title/edit-title/{id}','Modules\WikiTitle\WikiTitleController@edit')->name('admin.manage.wiki.title.edit');
      Route::post('manage-wiki-title/update-title','Modules\WikiTitle\WikiTitleController@update')->name('admin.manage.wiki.title.update');

      Route::post('manage-wiki-title/delete-title','Modules\WikiTitle\WikiTitleController@deleteImage')->name('admin.manage.wiki.title.delete.image');

      // manage-language
      Route::any('manage-language','Modules\Language\LanguageController@index')->name('admin.manage.language');
      Route::get('manage-language/add-language','Modules\Language\LanguageController@addView')->name('admin.manage.language.add-view');
      Route::post('manage-language/check-language','Modules\Language\LanguageController@check')->name('admin.manage.language.check');
      Route::post('manage-language/insert-language','Modules\Language\LanguageController@add')->name('admin.manage.language.insert');
      Route::get('manage-language/delete-language/{id}','Modules\Language\LanguageController@delete')->name('admin.manage.language.delete');
      Route::get('manage-language/edit-language/{id}','Modules\Language\LanguageController@edit')->name('admin.manage.language.edit');
      Route::post('manage-language/update-language','Modules\Language\LanguageController@update')->name('admin.manage.language.update');


      // manage-rejection
      Route::any('manage-reason','Modules\Rejection\RejectionController@index')->name('admin.manage.reason');
      Route::get('manage-reason/add-reason','Modules\Rejection\RejectionController@addView')->name('admin.manage.reason.add-view');
      Route::post('manage-reason/check-reason','Modules\Rejection\RejectionController@check')->name('admin.manage.reason.check');
      Route::post('manage-reason/insert-reason','Modules\Rejection\RejectionController@add')->name('admin.manage.reason.insert');
      Route::get('manage-reason/edit-reason/{id}','Modules\Rejection\RejectionController@edit')->name('admin.manage.reason.edit');
      Route::post('manage-reason/update','Modules\Rejection\RejectionController@update')->name('admin.manage.reason.update');
      Route::get('manage-reason/delete/{id}','Modules\Rejection\RejectionController@delete')->name('admin.manage.reason.delete');

      // sub-menus
      Route::get('product-sub-menu','HomeController@submenu')->name('admin.product.sub.menu');
      Route::get('horoscope-sub-menu','HomeController@submenu')->name('admin.horoscope.sub.menu');
      Route::get('gemstone-sub-menu','HomeController@submenu')->name('admin.gemstone.sub.menu');
      Route::get('order-sub-menu','HomeController@submenu')->name('admin.order.sub.menu');
      Route::get('settings-sub-menu','HomeController@submenu')->name('admin.settings.sub.menu');
      Route::get('blog-sub-menu','HomeController@submenu')->name('admin.blog.sub.menu');
      Route::get('site-user-sub-menu','HomeController@submenu')->name('admin.site.user.sub.menu');
      Route::get('seller-sub-menu','HomeController@submenu')->name('admin.seller.sub.menu');
      Route::get('puja-sub-menu','HomeController@submenu')->name('admin.puja.sub.menu');

});
