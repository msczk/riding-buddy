import $ from 'jquery';
import * as bootstrap from 'bootstrap';

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

$('.copyClipBoard').on('click', function()
{
    navigator.permissions.query({ name: "clipboard-write" }).then((result) => {
        if (result.state === "granted" || result.state === "prompt") {
            navigator.clipboard.writeText($(this).data('copy'))
        }
    });

    const tooltip = bootstrap.Tooltip.getInstance($(this))
     // Returns a Bootstrap tooltip instance

    // setContent example
    tooltip.setContent({ '.tooltip-inner': txt_copied })
});

