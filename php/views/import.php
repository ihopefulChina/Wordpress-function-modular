<?php

/**
 * HTML code for the Import Snippets page
 *
 * @package Code_Snippets
 * @subpackage Views
 */

/* Bail if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$max_size_bytes = apply_filters( 'import_upload_size_limit', wp_max_upload_size() );

?>
<div class="wrap">
	<h1><?php _e( '导入函数模块', 'code-snippets' );

		$admin = code_snippets()->admin;

		if ( $admin->is_compact_menu() ) {

			printf( '<a href="%2$s" class="page-title-action">%1$s</a>',
				esc_html_x( 'Manage', 'snippets', 'code-snippets' ),
				code_snippets()->get_menu_url()
			);

			printf( '<a href="%2$s" class="page-title-action">%1$s</a>',
				esc_html_x( 'Add New', 'snippet', 'code-snippets' ),
				code_snippets()->get_menu_url( 'add' )
			);

			if ( isset( $admin->menus['settings'] ) ) {
				printf( '<a href="%2$s" class="page-title-action">%1$s</a>',
					esc_html_x( 'Settings', 'snippets', 'code-snippets' ),
					code_snippets()->get_menu_url( 'settings' )
				);
			}
		}

	?></h1>

	<div class="narrow">

		<p><?php _e( '上传一个或多个代码函数导出文件，将导入函数模块化.', 'code-snippets' ); ?></p>

		<p><?php
			printf(
				/* translators: %s: link to snippets admin menu */
				__( '之后，您需要访问<a href="%s">“全部函数模块化页面”</a>页面以激活导入的函数。', 'code-snippets' ),
				code_snippets()->get_menu_url( 'manage' )
			); ?></p>


		<form enctype="multipart/form-data" id="import-upload-form" method="post" class="wp-upload-form" name="code_snippets_import">

			<h2><?php _e( '重复函数', 'code-snippets' ); ?></h2>

			<p class="description">
				<?php esc_html_e( '如果找到的现有函数代码与导入的函数代码段具有相同的名称，会发生什么情况？', 'code-snippets' ); ?>
			</p>

			<fieldset>
				<p>
					<label>
						<input type="radio" name="duplicate_action" value="ignore" checked="checked">
						<?php esc_html_e( '忽略任何重复的函数代码：无论如何都从文件中导入所有函数代码，并保持所有现有函数代码不变。', 'code-snippets' ); ?>
					</label>
				</p>

				<p>
					<label>
						<input type="radio" name="duplicate_action" value="replace">
						<?php esc_html_e( '使用新导入的同名函数代码替换任何现有的函数代码。', 'code-snippets' ); ?>
					</label>
				</p>

				<p>
					<label>
						<input type="radio" name="duplicate_action" value="skip">
						<?php esc_html_e( '不要导入任何重复的函数代码; 保留所有现有的函数代码不变。', 'code-snippets' ); ?>
					</label>
				</p>
			</fieldset>

			<h2><?php _e( '上传函数', 'code-snippets' ); ?></h2>

			<p class="description">
				<?php _e( '选择一个或多个要上传的函数代码（.xml或.json）文件，然后单击“上载文件并导入”。', 'code-snippets' ); ?>
			</p>

			<fieldset>
				<p>
					<label for="upload"><?php esc_html_e( '从您的计算机中选择文件:', 'code-snippets' ); ?></label>
					<?php printf(
						/* translators: %s: size in bytes */
						esc_html__( '(最大不超过: %s)', 'code-snippets' ),
						size_format( $max_size_bytes )
					); ?>
					<input type="file" id="upload" name="code_snippets_import_files[]" size="25" accept="application/json,.json,text/xml" multiple="multiple">
					<input type="hidden" name="action" value="save">
					<input type="hidden" name="max_file_size" value="<?php echo esc_attr( $max_size_bytes ); ?>">
				</p>
			</fieldset>

			<?php
			do_action( 'code_snippets/admin/import_form' );
			submit_button( __( '上传函数文件并导入', 'code-snippets' ) );
			?>
		</form>
	</div>
</div>
