INSTALLED_APPS = [
    # Other apps
    'pwa',
]

PWA_APP_NAME = 'luckygames'
PWA_APP_DESCRIPTION = "A simple progressive web app for games"
PWA_APP_THEME_COLOR = '#681ce3'
PWA_APP_BACKGROUND_COLOR = '#171b24'
PWA_APP_SCOPE = '/'
PWA_APP_START_URL = '/index.html'
PWA_APP_DISPLAY = 'standalone'
PWA_APP_ICON = 'path_to_your_icon'
PWA_APP_ICONS = [
    {
        'src': 'icon-192x192.png',
        'sizes': '192x192',
        'type': 'image/png'
    },
    {
        'src': 'icon-512x512.png',
        'sizes': '512x512',
        'type': 'image/png'
    },
]
