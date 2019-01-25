function checkImagesOnLoad() {
  let $imgInput = $('.img-input');

  $imgInput
    .each((e, input) => {
      checkImage($(input));
    })
    .on('keyup', (e) => {
      checkImage($(e.target));
    });
}

function checkImage(that) {
  let url = that.val(),
      $image = that.prev();

  $.get(url)
    .done(() => {
      $image.attr('src', url);
    }).fail(() => {
      $image.attr('src', emailEditorImageDir + '/brokenImage.png');
    });
}

$(checkImagesOnLoad);
