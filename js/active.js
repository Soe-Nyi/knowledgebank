function updateUserStatus() {
    jQuery.ajax({
        url: 'update.php',
        success: function() {}
    });
}

setInterval(function() {
    updateUserStatus();
}, 3000);