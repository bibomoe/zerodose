<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swagger UI - CodeIgniter</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/swagger-ui/dist/swagger-ui.css'); ?>">
    <script src="<?php echo base_url('assets/swagger-ui/dist/swagger-ui-bundle.js'); ?>"></script>
    <script src="<?php echo base_url('assets/swagger-ui/dist/swagger-ui-standalone-preset.js'); ?>"></script>
</head>
<body>
    <div id="swagger-ui"></div>
    <script>
        const ui = SwaggerUIBundle({
            url: "<?php echo base_url('assets/swagger.json'); ?>",  // Swagger JSON file path
            dom_id: '#swagger-ui',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            layout: "BaseLayout",
        });
    </script>
</body>
</html>
