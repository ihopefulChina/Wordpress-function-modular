<?php

/**
 * Retrieve the default setting values
 * @return array
 */
function code_snippets_get_default_settings() {
	static $defaults;

	if ( isset( $defaults ) ) {
		return $defaults;
	}

	$defaults = array();

	foreach ( code_snippets_get_settings_fields() as $section_id => $fields ) {
		$defaults[ $section_id ] = array();

		foreach ( $fields as $field_id => $field_atts ) {
			$defaults[ $section_id ][ $field_id ] = $field_atts['default'];
		}
	}

	return $defaults;
}

/**
 * Retrieve the settings fields
 * @return array
 */
function code_snippets_get_settings_fields() {
	static $fields;

	if ( isset( $fields ) ) {
		return $fields;
	}

	$fields = array();

	$fields['general'] = array(
		'activate_by_default' => array(
			'name'    => __( '默认激活运行', 'code-snippets' ),
			'type'    => 'checkbox',
			'label'   => __( "保存代码段时，将“保存并运行”按钮设为默认操作。", 'code-snippets' ),
			'default' => true,
		),

		'snippet_scope_enabled' => array(
			'name'    => __( '启用范围选择器', 'code-snippets' ),
			'type'    => 'checkbox',
			'label'   => __( '编辑代码段时启用范围选择器', 'code-snippets' ),
			'default' => true,
		),

		'enable_tags' => array(
			'name'    => __( '启用片段标签', 'code-snippets' ),
			'type'    => 'checkbox',
			'label'   => __( '在管理页面上显示代码段标签', 'code-snippets' ),
			'default' => true,
		),

		'enable_description' => array(
			'name'    => __( '启用代码段说明', 'code-snippets' ),
			'type'    => 'checkbox',
			'label'   => __( '在管理页面上显示摘要说明', 'code-snippets' ),
			'default' => true,
		),

		'disable_prism' => array(
			'name'    => __( '禁用短代码语法高亮显示', 'code-snippets' ),
			'type'    => 'checkbox',
			'label'   => __( '禁用前端[code_snippet]短代码的语法高亮显示', 'code-snippets' ),
			'default' => false,
		),

		'complete_uninstall' => array(
			'name'    => __( '完全卸载', 'code-snippets' ),
			'type'    => 'checkbox',
			'label'   => sprintf(
				/* translators: %s: URL for Plugins admin menu */
				__( '插件菜单中删除<a href="%s">插件</a>时，还要删除所有片段和插件设置。', 'code-snippets' ),
				self_admin_url( 'plugins.php' )
			),
			'default' => false,
		),
	);

	if ( is_multisite() && ! is_main_site() ) {
		unset( $fields['general']['complete_uninstall'] );
	}

	/* Description Editor settings section */
	$fields['description_editor'] = array(

		'rows' => array(
			'name'    => __( '行高', 'code-snippets' ),
			'type'    => 'number',
			'label'   => __( '行', 'code-snippets' ),
			'default' => 5,
			'min'     => 0,
		),

		'use_full_mce' => array(
			'name'    => __( '使用完整编辑器', 'code-snippets' ),
			'type'    => 'checkbox',
			'label'   => __( '启用可视编辑器的所有功能', 'code-snippets' ),
			'default' => false,
		),

		'media_buttons' => array(
			'name'    => __( '媒体按钮', 'code-snippets' ),
			'type'    => 'checkbox',
			'label'   => __( '启用添加媒体按钮', 'code-snippets' ),
			'default' => false,
		),
	);

	/* Code Editor settings section */

	$fields['editor'] = array(
		'theme' => array(
			'name'       => __( '主题', 'code-snippets' ),
			'type'       => 'codemirror_theme_select',
			'default'    => 'default',
			'codemirror' => 'theme',
		),

		'indent_with_tabs' => array(
			'name'       => __( '缩进选项卡', 'code-snippets' ),
			'type'       => 'checkbox',
			'label'      => __( '使用硬标签（而不是空格）进行缩进。', 'code-snippets' ),
			'default'    => true,
			'codemirror' => 'indentWithTabs',
		),

		'tab_size' => array(
			'name'       => __( '标签大小', 'code-snippets' ),
			'type'       => 'number',
			'desc'       => __( '制表符的宽度。', 'code-snippets' ),
			'default'    => 4,
			'codemirror' => 'tabSize',
			'min'        => 0,
		),

		'indent_unit' => array(
			'name'       => __( '缩进单位', 'code-snippets' ),
			'type'       => 'number',
			'desc'       => __( '块应缩进多少个空格。', 'code-snippets' ),
			'default'    => 4,
			'codemirror' => 'indentUnit',
			'min'        => 0,
		),

		'wrap_lines' => array(
			'name'       => __( '包裹线', 'code-snippets' ),
			'type'       => 'checkbox',
			'label'      => __( '编辑器是否应滚动或换行以排长行。', 'code-snippets' ),
			'default'    => true,
			'codemirror' => 'lineWrapping',
		),

		'line_numbers' => array(
			'name'       => __( '行号', 'code-snippets' ),
			'type'       => 'checkbox',
			'label'      => __( '在编辑器左侧显示行号。', 'code-snippets' ),
			'default'    => true,
			'codemirror' => 'lineNumbers',
		),

		'auto_close_brackets' => array(
			'name'       => __( '自动关闭括号', 'code-snippets' ),
			'type'       => 'checkbox',
			'label'      => __( '键入时自动关闭括号和引号。', 'code-snippets' ),
			'default'    => true,
			'codemirror' => 'autoCloseBrackets',
		),

		'highlight_selection_matches' => array(
			'name'       => __( '突出显示选择匹配', 'code-snippets' ),
			'label'      => __( '突出显示当前所选单词的所有实例。', 'code-snippets' ),
			'type'       => 'checkbox',
			'default'    => true,
			'codemirror' => 'highlightSelectionMatches',
		),
	);

	$fields = apply_filters( 'code_snippets_settings_fields', $fields );

	return $fields;
}
