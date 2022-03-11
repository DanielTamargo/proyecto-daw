hicon.replace();
    $(document).ready(function() {
        initDrag();
    });
    // Button
    $(".btn-clickable").click(function() {
        setTimeout(function() {
            $(".slider").addClass("sldr-opa");
        }, 199); 
        setTimeout(function() {
            $(".slider").addClass("sldr-pos");
        }, 299); 
        setTimeout(function() {
            $(".button").removeClass("btn-clickable");
            $(".text-c").text("Hecho");
            $(".icon").removeClass("icon-check");
            loadController();
        }, 359);  
        setTimeout(function() {
            $(".icon").removeClass("icon-opa");
        }, 499); 
    });


    // Slider
    // Initial status
    var controller = $(".controller");
    TweenMax.set(controller, {scale: 0, opacity: 0});

    var sliderContainer = $(".endpoint-container"),
        tl = new TimelineLite(),
        dropTargets = $(".endpoint"),
        totlaTarges = 1,
        totalHit = 0;


    // After load status
    function loadController() {
        TweenMax.staggerTo(controller, .2, {scale: 1,opacity: 1, ease: Back.easeOut, force3D: true}), initDrag;
    };

    function initDrag() {
        Draggable.create(controller, {
            bounds: sliderContainer,
            edgeResistance: 1,
            type:'x',
            onPress: function() {
                this.sartX = this.x;
                this.sartY = this.y;
                this.offsetTop = this.startY - $(this.target).position().top;
                this.offsetLeft = this.startX - $(this.target).position().left;
            },
            onDragStart: function(){ 
                $(".slider").toggleClass("sldr-drag");
                $(".slider-text").toggleClass("text-d");
            }, 
            onDragEnd: function() {
                var dragThing = this;
                var dragID = this.target.id + "Drop";

                $.each(dropTargets, function (idx, spot) {
                    var spotID = spot.id;
                    var pos = $(spot).position();
                    var diffTop = dragThing.offsetTop + pos.top;
                    var diffLeft = dragThing.offsetLeft + pos.left;


                    if (spotID === dragID) {
                        if(dragThing.hitTest(spot, "70%")) {
                            TweenMax.to(dragThing.target, .1, {x: diffLeft, y: diffTop, marginTop: "4px", marginLeft: "3px"});
                            TweenMax.staggerTo(controller, .5, {scale: 0,opacity: 0, delay: .5, ease: Back.easeOut, force3D: true}, SliderOff);
                            // Post action 
                            function SliderOff() {
                                setTimeout(function() {
                                    $(".slider").removeClass("sldr-opa");
                                }, 499); 
                                setTimeout(function() {
                                    $(".slider").removeClass("sldr-pos");
                                }, 799); 
                                setTimeout(function() {
                                    $(".el-wrap").addClass("el-wrap-shield");
                                }, 499);
                            }
                        } else {
                            TweenMax.to(dragThing.target, .5, {x: dragThing.startX, y: dragThing.startY});
                        }
                    }
                });
                $(".slider").toggleClass("sldr-drag");
                $(".slider-text").toggleClass("text-d");
                setTimeout(function() {
                    despues();
                }, 700);
                
            }
        })
    };