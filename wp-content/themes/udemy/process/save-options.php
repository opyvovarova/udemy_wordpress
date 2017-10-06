<?php

function op_save_options() {
	if( !current_user_can( 'edit_theme_options' ) ){//проверяет права текушего пользователя
		wp_die(__('You are not allowed to be on this page.') );
	}
	check_admin_referer( 'op_options_verify' );//проверяет был ли текущий запрос отправлен со стороны админки
	$opts               =   get_option( 'op_opts' );//получает значение указанной настройки(опции)
	$opts['twitter']    =   sanitize_text_field($_POST( 'op_inputTwitter'));//очищает строку передаваемую из поля input(удаляет все лишнееб оставляя чистый текст)
	$opts['facebook']   =   sanitize_text_field($_POST( 'op_inputFacebook'));
	$opts['youtube']    =   sanitize_text_field($_POST( 'op_inputYoutube'));
	$opts['logo_type']  =   absint( $_POST('op_inputLogoType') );//конвертирует значени в положительное целое число
	$opts['footer']     =   $_POST('op_inputFooter');
	$opts['logo_img']   =   esc_url_raw($_POST('op_inputLogoImg'));//очищает URL для безопасного использования к запросе к БД. , при редиректах и HTTP запросах
	update_option( 'op_opts', $opts );//обновляет значение опции(настройки) в базе данных
	wp_redirect( admin_url('') );//перенаправляет редирект на указанный url админ
}
