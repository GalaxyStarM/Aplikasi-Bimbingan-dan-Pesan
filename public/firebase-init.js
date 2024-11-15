document.addEventListener('DOMContentLoaded', function() {
    if (!firebase.apps.length) {
        $.ajax({
            url: '/firebase-config',
            method: 'GET',
            success: function(config) {
                firebase.initializeApp(config);
            },
            error: function(err) {
                console.error('Firebase config error:', err);
            }
        });
    }
});