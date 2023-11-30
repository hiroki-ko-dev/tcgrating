document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('[name="sub_category_id"]').forEach(function (radio) {
    radio.addEventListener('change', function () {
      document.querySelector('form').submit();
    });
  });
});