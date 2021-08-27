var iconText = $('#copy-icon-input');
var bannerText = $('#copy-banner-input');
var previewText = $('#copy-preview-input');

var btnCopyIcon = $('#btn-copy-icon');
var btnCopyBanner = $('#btn-copy-banner');
var btnCopyPreview = $('#btn-copy-preview');

// copy text on click
btnCopyIcon.on('click', function () {
  iconText.select();
  document.execCommand('copy');
  toastr['success']('', 'Copied to clipboard!');
});
btnCopyBanner.on('click', function () {
  bannerText.select();
  document.execCommand('copy');
  toastr['success']('', 'Copied to clipboard!');
});
btnCopyPreview.on('click', function () {
  previewText.select();
  document.execCommand('copy');
  toastr['success']('', 'Copied to clipboard!');

});
