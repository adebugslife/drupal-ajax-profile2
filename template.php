<?php

/**
 * @file
 * Display ajax value in Profile2 user registration page
 * @refs API:http://api.drupalhelp.net/api/profile2/profile2.api.php/7
 * 
 */

function YOURMODULE_form_profile2_edit_PROFILE2NAME_form_alter(&$form, &$form_state) {
	
	/*
	 * Field that triggers Ajax request: 
	 * Make sure that you add #ajax property on $form['PROFILE_TYPE']['FIELD_NAME']['und']
	 * Make sure #type doesn't have CONTAINER value
	 * You can check field #type using Devel module
	 */
	$form['PROFILE_TYPE']['FIELD_NAME']['und']['#ajax'] = array(
		'callback' => 'custom_ajax_callback',
		'wrapper' => 'wrapper-div',
	);

	/*
	 * Ajax Wrapper
	 * Where the Ajax result will be displayed
	 */
 $form['PROFILE_TYPE']['CUSTOM_AJAX_FIELDNAME'] = array(
    '#title' => t('My Title'),
    '#prefix' => '<div id="wrapper-div">',
    '#suffix' => '</div>',
    '#weight' => 65,
    '#type' => 'fieldset',
    '#description' =>  t('Serve a fieldset holder for ajax request'),
  );
	
		if (isset($form_state['values']['PROFILE_TYPE']['FIELD_NAME']) ) {
			
			// Get the Value
			$membership = $form_state['values']['PROFILE_TYPE']['FIELD_NAME']['und'][0]['value'];

			//Sample Logic what you can do with the value that was fetch from Dependee field
			if (!empty($membership)) {
				switch ($membership) {
					case 'premium': 
						$fees = 70;
						break;
					case 'standard':
						$fees = 45;
						break;
					default:
						$fees = 70;
				}				
			} else {
					$fees = 70;
			}
			// Display results
			$form['PROFILE_TYPE']['CUSTOM_AJAX_FIELDNAME']['#description']= t('Fees: $@fees', array('@fees' => $fees) );
	}
	return $form;
 }

function custom_ajax_callback($form, $form_state){
	return $form['PROFILE_TYPE']['CUSTOM_AJAX_FIELDNAME']; // The wrapper that holds the value
}

