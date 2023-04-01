/**
 * 
 * Thiago Soares de Souza
 * Web Server Applications
 * 29 March 2023
 * LaSalle College
 * Web Server Project - JS to prevent the user to enter other not necessary keys
 * 
 */


jQuery(function () {
    /**
     * only allow numbers and controls for the field from the games with answer_num
     */
    $("#answer_num").on("keypress", function (event) {
      //$("div").html("Key: " + event.which);
      if (
        ((event.keyCode < 48 || event.keyCode > 57)) &&
        event.keyCode != 8 && // backspace
        event.keyCode != 9 && // tab
        event.keyCode != 13 && // enter
        event.keyCode != 20 && // capslock
        event.keyCode != 27 && // escape
        event.keyCode != 33 && // pageup
        event.keyCode != 34 && // pagedown
        event.keyCode != 35 && // end
        event.keyCode != 36 && // home
        event.keyCode != 37 && // left arrow
        event.keyCode != 39 && // right arrow
        event.keyCode != 44 && // print screen
        event.keyCode != 46 && // delete
        event.keyCode != 116 && // f5
        event.keyCode != 144 && // numlock
        event.keyCode != 145 && // scrolllock
        event.keyCode != 173 && // audio mute
        event.keyCode != 174 && // audio volume down
        event.keyCode != 175 && // audio volume up
        !event.metaKey && // windows key
        !event.altKey && // alt
        !(event.ctrlKey && event.key === "a") && // ctrl + a
        !(event.shiftKey && event.keyCode == 9) // shift + tab
      ) {
        event.preventDefault();
      }
    });


    /**
     * only allow letters and controls for the field from the games with answer_let
     */
    $("#answer_let").on("keypress", function (event) {
        //$("div").html("Key: " + event.which);
        if (
          ((event.keyCode < 97 || event.keyCode > 122)) &&
          event.keyCode != 8 && // backspace
          event.keyCode != 9 && // tab
          event.keyCode != 13 && // enter
          event.keyCode != 20 && // capslock
          event.keyCode != 27 && // escape
          event.keyCode != 33 && // pageup
          event.keyCode != 34 && // pagedown
          event.keyCode != 35 && // end
          event.keyCode != 36 && // home
          event.keyCode != 37 && // left arrow
          event.keyCode != 39 && // right arrow
          event.keyCode != 44 && // print screen
          event.keyCode != 46 && // delete
          event.keyCode != 116 && // f5
          event.keyCode != 144 && // numlock
          event.keyCode != 145 && // scrolllock
          event.keyCode != 173 && // audio mute
          event.keyCode != 174 && // audio volume down
          event.keyCode != 175 && // audio volume up
          !event.metaKey && // windows key
          !event.altKey && // alt
          !(event.ctrlKey && event.key === "a") && // ctrl + a
          !(event.shiftKey && event.keyCode == 9) // shift + tab
        ) {
          event.preventDefault();
        }
    });

});


// jQuery(function () {
//     /**
//      * only allow numbers or letters and controls for the field answer
//      */
//     $("#answer").on("keypress", function (event) {
//       //$("div").html("Key: " + event.which);
//       if (
//         (!((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 97 && event.keyCode <= 122))) &&
//         event.keyCode != 8 && // backspace
//         event.keyCode != 9 && // tab
//         event.keyCode != 13 && // enter
//         event.keyCode != 20 && // capslock
//         event.keyCode != 27 && // escape
//         event.keyCode != 33 && // pageup
//         event.keyCode != 34 && // pagedown
//         event.keyCode != 35 && // end
//         event.keyCode != 36 && // home
//         event.keyCode != 37 && // left arrow
//         event.keyCode != 39 && // right arrow
//         event.keyCode != 44 && // print screen
//         event.keyCode != 46 && // delete
//         event.keyCode != 116 && // f5
//         event.keyCode != 144 && // numlock
//         event.keyCode != 145 && // scrolllock
//         event.keyCode != 173 && // audio mute
//         event.keyCode != 174 && // audio volume down
//         event.keyCode != 175 && // audio volume up
//         !event.metaKey && // windows key
//         !event.altKey && // alt
//         !(event.ctrlKey && event.key === "a") && // ctrl + a
//         !(event.shiftKey && event.keyCode == 9) // shift + tab
//       ) {
//         event.preventDefault();
//       }
//     });
// });