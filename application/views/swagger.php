<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swagger UI - CodeIgniter</title>
    <!-- Link to the Swagger UI CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/extensions/swagger-ui/dist/swagger-ui.css'); ?>">
</head>
<body>
    <!-- Swagger UI container -->
    <div id="swagger-ui"></div>

    <!-- Include Swagger UI JS files -->
    <script src="<?php echo base_url('assets/extensions/swagger-ui/dist/swagger-ui-bundle.js'); ?>"></script>
    <script src="<?php echo base_url('assets/extensions/swagger-ui/dist/swagger-ui-standalone-preset.js'); ?>"></script>

    <script>
        const ui = SwaggerUIBundle({
            url: "<?php echo base_url('assets/swagger-json/swagger.json'); ?>",  // Point to your Swagger JSON file
            dom_id: '#swagger-ui',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset,
                SwaggerUIBundle.presets.oauth2  // Make sure OAuth2 is enabled
            ],
            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl
            ],
            layout: "StandaloneLayout", // Make sure layout is StandaloneLayout
            // Define security scheme for authorization (e.g., Bearer Token)
            securityDefinitions: {
                "bearerAuth": {
                    "type": "apiKey",
                    "in": "header",
                    "name": "Authorization",
                    "description": "Bearer token authorization"
                }
            },
            security: [
                { "bearerAuth": [] }  // Make sure to link the bearerAuth security scheme
            ]
        });
    </script>
</body>
</html>
