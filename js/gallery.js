$(function() {
    $(".img-w").each(function() {
      $(this).wrap("<div class='img-c'></div>")
      let imgSrc = $(this).find("img").attr("src");
       $(this).css('background-image', 'url(' + imgSrc + ')');
    })
              
    
    $(".img-c").click(function() {
      let w = $(this).outerWidth()
      let h = $(this).outerHeight()
      let x = $(this).offset().left
      let y = $(this).offset().top
      
      
      $(".active").not($(this)).remove()
      let copy = $(this).clone();
      copy.insertAfter($(this)).height(h).width(w).delay(500).addClass("active")
      $(".active").css('top', y - 8);
      $(".active").css('left', x - 8);
      
        setTimeout(function() {
      copy.addClass("positioned")
    }, 0)
      
    }) 
    
    
  
    
  })
  
  $(document).on("click", ".img-c.active", function() {
    let copy = $(this)
    copy.removeClass("positioned active").addClass("postactive")
    setTimeout(function() {
      copy.remove();
    }, 500)
  })


  document.addEventListener("DOMContentLoaded", () => {
    const galleryItems = document.querySelectorAll(".gallery-item");

    galleryItems.forEach(item => {
        item.addEventListener("click", () => {
            const src = item.querySelector("img").src;
            toggleLightbox(src);
        });
    });

    function toggleLightbox(src) {
        let lightbox = document.getElementById("lightbox");
        
        if (!lightbox) {
            lightbox = document.createElement("div");
            lightbox.id = "lightbox";
            document.body.appendChild(lightbox);

            const img = document.createElement("img");
            lightbox.appendChild(img);

            lightbox.addEventListener("click", () => {
                lightbox.classList.toggle("visible");
            });
        }

        const img = lightbox.querySelector("img");
        img.src = src;
        lightbox.classList.toggle("visible");
    }
});
