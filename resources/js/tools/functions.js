import $ from 'jquery';

$('.copyClipBoard').on('click', function()
{
    navigator.permissions.query({ name: "clipboard-write" }).then((result) => {
        if (result.state === "granted" || result.state === "prompt") {
            navigator.clipboard.writeText($(this).data('copy'))
        }
      });
});