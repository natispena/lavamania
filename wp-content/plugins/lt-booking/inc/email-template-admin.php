<html>
    <body>
        <div>
            <h1 style="padding: 0 0 0 0; font-family: Arial; font-weight: 600; font-size:24px;">
                <?php echo esc_html(ltb_parse_email_fields($post_id, $config, $config['admin-subject'])); ?>
            </h1>

            <div style="max-width:600px; padding:0 0 0 0; font-family: Arial;">
                <?php echo wp_kses_post(nl2br(ltb_parse_email_fields($post_id, $config, $config['admin-text']))); ?>
            </div>
        </div>
    </body>
</html>