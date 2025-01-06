$(document).ready(function() {
  var waiting = false;
  $(".like-btn, .unlike-btn").click(function(){
    if(waiting == true) {
      return false;
    }
    waiting = true;
    var post_id = $(this).data("post");
    var user_id = $(this).data("user");
    var counter = $(this).find(".mar-counter");
    var button = $(this);

    $.ajax({
      type: "POST",
      url: "like.php",
      data: { like: post_id, user_id: user_id },
      cache: false,
      success: function (data) {
        counter.text(data);
        button.toggleClass("like-btn unlike-btn");
        button.find('.material-symbols-outlined').toggleClass("like-symbol unlike-symbol");
        waiting = false;
          
      },
    });
  });
  // $(".unlike-btn").click(function(){
  //   var post_id = $(this).data("post");
  //   var user_id = $(this).data("user");
  //   var counter = $(this).find(".mar-counter");
  //   var button = $(this);

  //   $.ajax({
  //     type: "POST",
  //     url: "like.php",
  //     data: { like: post_id, user_id: user_id },
  //     cache: false,
  //     success: function (data) {
  //       counter.text(data);
  //       button.toggleClass();
  //       button.find('.material-symbols-outlined').removeClass('unlike-btn').addClass('like-btn');
          
  //     },
  //   });
  // });
});
