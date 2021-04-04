$(function () {
    resize();
});
causeRepaintsOn = $("h1, h2, h3, p");

$(window).on('resize', function () {
    resize();
    causeRepaintsOn.css("z-index", 1);
});

function resize(){
    var liWidth = $("li").css("width");
    $("li").css({"height":liWidth,"lineHeight": liWidth});
    var totalHeight = $("#wordsearch").css("width");
    $("#wordsearch").css("height", totalHeight);
}

var number=new Array('two','three','four','five','six','seven','eight','nine','ten','eleven','twelve','thirteen','fourteen','fifteen');
$(function () {
            // 4 //
            $(this).delay(1500).queue(function () {
                $(".one").addClass("selected");
                $(this).dequeue();
                further();
            })
        function further()
        {       
            number.forEach(function(item) 
            {
                $(this) .delay(500).queue(function () 
                {
                    $("."+item).addClass("selected");
                    $(this).dequeue();
                })
            })
        }
});

