	var clipboard = new Clipboard('.copybutton');

    clipboard.on('success', function(e) {
        // console.log(e);
        alert('Link Copied!');
    });

    clipboard.on('error', function(e) {
        // console.log(e);
        alert('Error Copying Link!');
    });