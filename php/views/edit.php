<?php

/**
 * HTML code for the Add New/Edit Snippet page
 *
 * @package Code_Snippets
 * @subpackage Views
 */

/* Bail if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$table = code_snippets()->db->get_table_name();
$edit_id = isset( $_REQUEST['id'] ) && intval( $_REQUEST['id'] ) ? absint( $_REQUEST['id'] ) : 0;
$snippet = get_snippet( $edit_id );

$classes = array();

if ( ! $edit_id ) {
	$classes[] = 'new-snippet';
} elseif ( 'single-use' === $snippet->scope ) {
	$classes[] = 'single-use-snippet';
} else {
	$classes[] = ( $snippet->active ? '' : 'in' ) . 'active-snippet';
}

?>
<div class="wrap">
	<h1><?php

		if ( $edit_id ) {
			esc_html_e( '编辑函数代码', 'code-snippets' );
			printf( ' <a href="%1$s" class="page-title-action add-new-h2">%2$s</a>',
				code_snippets()->get_menu_url( 'add' ),
				esc_html_x( '添加新的函数模块', 'snippet', 'code-snippets' )
			);
		} else {
			esc_html_e( '添加新的函数模块', 'code-snippets' );
		}

		$admin = code_snippets()->admin;

		if ( code_snippets()->admin->is_compact_menu() ) {

			printf( '<a href="%2$s" class="page-title-action">%1$s</a>',
				esc_html_x( 'Manage', 'snippets', 'code-snippets' ),
				code_snippets()->get_menu_url()
			);

			printf( '<a href="%2$s" class="page-title-action">%1$s</a>',
				esc_html_x( '导入', 'snippets', 'code-snippets' ),
				code_snippets()->get_menu_url( 'import' )
			);

			if ( isset( $admin->menus['settings'] ) ) {

				printf( '<a href="%2$s" class="page-title-action">%1$s</a>',
					esc_html_x( 'Settings', 'snippets', 'code-snippets' ),
					code_snippets()->get_menu_url( 'settings' )
				);
			}
		}

		?></h1>

	<form method="post" id="snippet-form" action="" style="margin-top: 10px;" class="<?php echo implode( ' ', $classes ); ?>">
		<?php
		/* Output the hidden fields */

		if ( 0 !== $snippet->id ) {
			printf( '<input type="hidden" name="snippet_id" value="%d" />', $snippet->id );
		}

		printf( '<input type="hidden" name="snippet_active" value="%d" />', $snippet->active );

		?>
		<div id="titlediv">
			<div id="titlewrap">
				<label for="title" style="display: none;"><?php _e( 'Name', 'code-snippets' ); ?></label>
				<input id="title" type="text" autocomplete="off" name="snippet_name" value="<?php echo esc_attr( $snippet->name ); ?>" placeholder="<?php _e( '这里填函数名字', 'code-snippets' ); ?>" />
			</div>
		</div>

		<h2>
			<label for="snippet_code">
				<?php _e( 'Code', 'code-snippets' ); ?>
			</label>
		</h2>

		<div class="snippet-editor">
			<textarea id="snippet_code" name="snippet_code" rows="200" spellcheck="false" style="font-family: monospace; width: 100%;"><?php
				echo esc_textarea( $snippet->code );
				?></textarea>

			<div class="snippet-editor-help">

				<div class="editor-help-tooltip cm-s-<?php
				echo esc_attr( code_snippets_get_setting( 'editor', 'theme' ) ); ?>"><?php
					echo esc_html_x( '?', 'help tooltip', 'code-snippets' ); ?></div>

				<?php

				$keys = array(
					'Cmd' => esc_html_x( 'Cmd', 'keyboard key', 'code-snippets' ),
					'Ctrl' => esc_html_x( 'Ctrl', 'keyboard key', 'code-snippets' ),
					'Shift' => esc_html_x( 'Shift', 'keyboard key', 'code-snippets' ),
					'Option' => esc_html_x( 'Option', 'keyboard key', 'code-snippets' ),
					'Alt' => esc_html_x( 'Alt', 'keyboard key', 'code-snippets' ),
					'F' => esc_html_x( 'F', 'keyboard key', 'code-snippets' ),
					'G' => esc_html_x( 'G', 'keyboard key', 'code-snippets' ),
					'R' => esc_html_x( 'R', 'keyboard key', 'code-snippets' ),
				);
				?>

				<div class="editor-help-text">
					<table>
						<tr>
							<td><?php esc_html_e( 'Begin searching', 'code-snippets' ); ?></td>
							<td><kbd class="pc-key"><?php echo $keys['Ctrl']; ?></kbd><kbd class="mac-key"><?php
									echo $keys['Cmd']; ?></kbd>&hyphen;<kbd><?php echo $keys['F']; ?></kbd></td>
						</tr>
						<tr>
							<td><?php esc_html_e( 'Find next', 'code-snippets' ); ?></td>
							<td><kbd class="pc-key"><?php echo $keys['Ctrl']; ?></kbd><kbd class="mac-key"><?php echo $keys['Cmd']; ?></kbd>&hyphen;<kbd><?php echo $keys['G']; ?></kbd></td>
						</tr>
						<tr>
							<td><?php esc_html_e( 'Find previous', 'code-snippets' ); ?></td>
							<td><kbd><?php echo $keys['Shift']; ?></kbd>-<kbd class="pc-key"><?php echo $keys['Ctrl']; ?></kbd><kbd class="mac-key"><?php echo $keys['Cmd']; ?></kbd>&hyphen;<kbd><?php echo $keys['G']; ?></kbd></td>
						</tr>
						<tr>
							<td><?php esc_html_e( 'Replace', 'code-snippets' ); ?></td>
							<td><kbd><?php echo $keys['Shift']; ?></kbd>&hyphen;<kbd class="pc-key"><?php echo $keys['Ctrl']; ?></kbd><kbd class="mac-key"><?php echo $keys['Cmd']; ?></kbd>&hyphen;<kbd><?php echo $keys['F']; ?></kbd></td>
						</tr>
						<tr>
							<td><?php esc_html_e( 'Replace all', 'code-snippets' ); ?></td>
							<td>
								<kbd><?php echo $keys['Shift']; ?></kbd>&hyphen;<kbd class="pc-key"><?php echo $keys['Ctrl']; ?></kbd><kbd class="mac-key"><?php echo $keys['Cmd']; ?></kbd><span class="mac-key">&hyphen;</span><kbd class="mac-key"><?php echo $keys['Option']; ?></kbd>&hyphen;<kbd><?php echo $keys['R']; ?></kbd>
							</td>
						</tr>
						<tr>
							<td><?php esc_html_e( 'Persistent search', 'code-snippets' ); ?></td>
							<td><kbd><?php echo $keys['Alt']; ?></kbd>&hyphen;<kbd><?php echo $keys['F']; ?></kbd></td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<?php
		/* Allow plugins to add fields and content to this page */
		do_action( 'code_snippets/admin/single', $snippet );

		/* Add a nonce for security */
		wp_nonce_field( 'save_snippet' );

		?>

		<p class="submit">
			<?php

			/* Make the 'Save and Activate' button the default if the setting is enabled */

			if ( $snippet->shared_network && is_network_admin() ) {

				submit_button( null, 'primary', 'save_snippet', false );

			} elseif ( 'single-use' === $snippet->scope ) {

				submit_button( null, 'primary', 'save_snippet', false );

				submit_button( __( 'Save Changes and Execute Once', 'code-snippets' ), 'secondary', 'save_snippet_execute', false );

			} elseif ( ! $snippet->active && code_snippets_get_setting( 'general', 'activate_by_default' ) ) {

				submit_button(
					__( '保存更改并运行', 'code-snippets' ),
					'primary', 'save_snippet_activate', false
				);

				submit_button( null, 'secondary', 'save_snippet', false );

			} else {

				/* Save Snippet button */
				submit_button( null, 'primary', 'save_snippet', false );

				/* Save Snippet and Activate/Deactivate button */
				if ( ! $snippet->active ) {
					submit_button(
						__( '保存更改并运行', 'code-snippets' ),
						'secondary', 'save_snippet_activate', false
					);

				} else {
					submit_button(
						__( '保存更改并取消运行', 'code-snippets' ),
						'secondary', 'save_snippet_deactivate', false
					);
				}
			}

			if ( 0 !== $snippet->id ) {

				/* Download button */

				if ( apply_filters( 'code_snippets/enable_downloads', true ) ) {
					submit_button( __( '下载', 'code-snippets' ), 'secondary', 'download_snippet', false );
				}

				/* Export button */

				submit_button( __( 'Export', 'code-snippets' ), 'secondary', 'export_snippet', false );

				/* Delete button */

				$confirm_delete_js = esc_js(
					sprintf(
						'return confirm("%s");',
						__( '您即将永久删除此函数代码。', 'code-snippets' ) . "\n" .
						__( "选择'取消'会停止 , '确定'会删除.", 'code-snippets' )
					)
				);

				submit_button(
					__( '删除', 'code-snippets' ),
					'secondary', 'delete_snippet', false,
					sprintf( 'onclick="%s"', $confirm_delete_js )
				);
			}

			?>
		</p>
	</form>
</div>
