<?php
   /*
      Plugin Name: ID usuario por email
      Plugin URI: http://www.santilimonche.es
      Description: Proporciona la ID de usaurio al enviar el correo por formulario
      Version: 1.0
      Author: Santiago Limonche
      Author URI: http://www.santilimonche.es
   */
  
  //Función que se llama cuando se realiza el ajax
  function conseguir_id_usuario() {
    //Conseguimos el correo
    $email = sanitize_text_field($_POST['email']);
    //Inicializamos la variable $wpdb
    global $wpdb;
    //Conseguimos la ID del usuario, si no existe el json devuelve null
    $ID = $wpdb->get_var("SELECT ID FROM ".$wpdb->base_prefix."users  WHERE user_email = '".$email."'");

    echo json_encode($ID);

    die();
  }
  add_action('wp_ajax_conseguir_id_usuario', 'conseguir_id_usuario');
  add_action('wp_ajax_nopriv_conseguir_id_usuario', 'conseguir_id_usuario'); 

  //Función que imprime el formulario
  function formulario_email_id() { ?>
    <form class="wordpress-ajax-form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
      <span>
        <input type="email" class="email_usuario" name="email_usuario" value="" size="30" aria-required="true" aria-invalid="false">
      </span>
        <input type="hidden" class="admin_ajax_url" value="<?php echo admin_url('admin-ajax.php'); ?>"  />
        <input type="hidden" name="action" value="conseguir_id_usuario">
      <button class="formulario_email_id">Conseguir ID</button>
    </form>
<?php
  }

  //Hacemos un shortcode para insertar el formulario en un post o págin
  function shortcode_formulario_email() {
    return formulario_email_id();
  }
  add_shortcode('formulario_email', 'shortcode_formulario_email');

  //Cargamos los js necesarios
  function functionality_ie_exec_scripts() {
    //Añadimos jQuery
    wp_deregister_script('jquery');
    wp_register_script('jquery', includes_url().'js/jquery/jquery.js');
    wp_enqueue_script('jquery');
    
        wp_enqueue_script( 'email-formulario-id-usuario', plugins_url(). '/plugin-email/js/search.js');
        
    
  }
  add_action( 'wp_enqueue_scripts', 'functionality_ie_exec_scripts' );

?>