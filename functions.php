<?php

//Connect To openweathermap it's required API Key 
//  Function Have parameter City and it's returning city Weather
function GetData($city)
{
    $apiKey = "Your Key";
    $googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?q=" . $city . "&lang=en&units=metric&appid=" . $apiKey;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);

    curl_close($ch);
    return json_decode($response);
}

// automatically Login after Registr User
function automatically_log_me_in($user_id)
{
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);
    wp_redirect(home_url('/'));
    exit();
}
add_action('user_register', 'automatically_log_me_in');


//Changing woocommerce Product Price By Product ID
// This function need two paramater first is product id and second new price
function change_product_price($product_id, $price)
{
    $_pf = new WC_Product_Factory();
    $product = $_pf->get_product($product_id);
    $product->set_price($price);
    $product->set_regular_price($price);
    $product->set_sale_price('');
    $product->save();
}


// Set Custom Routes and Include Custom Files
// This helping create custom routes in WordPress Without create page,template etc.
add_action('parse_request', 'CustomRoutes');
function CustomRoutes()
{
    if ((strpos($_SERVER["REQUEST_URI"], '/test') !== false)) {
        include  '/template/test.php';
        die();
    }
}


// Function For ACF Select Contact Form
function acf_contact_form_select($field)
{
    if (class_exists('wpcf7')) {
        $choices = [];
        $choices['0'] = 'Сhoose the form';

        $posts = WPCF7_ContactForm::find();

        foreach ($posts as $form) {
            $choices[$form->id()] = $form->title();
        }

        $field['choices'] = $choices;
    }

    return $field;
}
add_filter('acf/load_field/name=contact_form', 'acf_contact_form_select');

// Function For ACF Select Gravity Form
function acf_populate_gf_forms_ids($field)
{
    if (class_exists('GFFormsModel')) {
        $choices = [];
        $choices['0'] = 'Сhoose the form';

        foreach (\GFFormsModel::get_forms() as $form) {
            $choices[$form->id] = $form->title;
        }

        $field['choices'] = $choices;
    }

    return $field;
}
add_filter('acf/load_field/name=guidebook_before_form_shortcode', 'acf_populate_gf_forms_ids');