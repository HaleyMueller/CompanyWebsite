<script>

    var loadScript = function(src, callbackfn) {
        var newScript = document.createElement("script");
        newScript.type = "text/javascript";
        newScript.setAttribute("async", "true");
        newScript.setAttribute("src", src);

        if(newScript.readyState) {
            newScript.onreadystatechange = function() {
                if(/loaded|complete/.test(newScript.readyState)) callbackfn();
            }
        } else {
            newScript.addEventListener("load", callbackfn, false);
        }

        document.documentElement.firstChild.appendChild(newScript);
    }

    var slogan = [
        "A friendly company",
        "Makin' the world better one website at a time",
        "Don't be evil",
        "Melts in you mouth, not your hands",
        "Vote for the Bull-moose party",
        "Live in the moment",
        "Tell your friends that you appreciate them",
        "Did you leave the oven on?",
        "You smell that?",
        "We know why you are here",
        "That's the spirit!",
        "Removed Herobrine",
        "Villager > rest of cast",
        "\"Lt. Dan, you ain't got no legs\"",
        "My name Jeff"
    ];
    var today = new Date();
    var dd = today.getDay();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    var newyear = new Date(today.getFullYear(), 0, 1);
    if (today.setHours(0,0,0,0) == newyear.setHours(0,0,0,0))slogan = ["Happy New Year!"]

    var fourth = new Date(2018, 6, 4);
    if (today.setHours(0,0,0,0) == fourth.setHours(0,0,0,0))slogan = ["Happy Fourth of July!"]

    var easter = new Date(today.getFullYear(), 3, 24);
    if (today.setHours(0,0,0,0) == easter.setHours(0,0,0,0))slogan = ["Happy Easter!"]

    var halloweenMin = new Date(today.getFullYear(), 9, 24);
    var halloween = new Date(today.getFullYear(), 10, 1);
    if (today.setHours(0,0,0,0) < halloween.setHours(0,0,0,0) && today.setHours(0,0,0,0) > halloweenMin.setHours(0,0,0,0)){
        slogan = ["Happy Halloween!", "It's spooktober"];
        loadScript("https://cdn.delphitools.info/wp-content/uploads/2013/10/jsbat.js?1.2", function() {  });loadScript("https://cdn.delphitools.info/wp-content/uploads/2013/10/jsbat.js?1.2", function() {  });
        loadScript("https://cdn.delphitools.info/wp-content/uploads/2013/10/jsbat.js?1.2", function() {  });loadScript("https://cdn.delphitools.info/wp-content/uploads/2013/10/jsbat.js?1.2", function() {  });
        loadScript("https://cdn.delphitools.info/wp-content/uploads/2013/10/jsbat.js?1.2", function() {  });loadScript("https://cdn.delphitools.info/wp-content/uploads/2013/10/jsbat.js?1.2", function() {  });
        loadScript("https://cdn.delphitools.info/wp-content/uploads/2013/10/jsbat.js?1.2", function() {  });loadScript("https://cdn.delphitools.info/wp-content/uploads/2013/10/jsbat.js?1.2", function() {  });
        loadScript("https://cdn.delphitools.info/wp-content/uploads/2013/10/jsbat.js?1.2", function() {  });loadScript("https://cdn.delphitools.info/wp-content/uploads/2013/10/jsbat.js?1.2", function() {  });
    }

    var christmasMin = new Date(today.getFullYear(), 10, 31);
    var christmas = new Date(today.getFullYear(), 1, 1);
    if (today.setHours(0,0,0,0) < christmas.setHours(0,0,0,0) && today.setHours(0,0,0,0) > christmasMin.setHours(0,0,0,0)){
        slogan = ["Merry Christmas!", "Happy Holidays!"];
        loadScript("https://cdn.rawgit.com/scottschiller/Snowstorm/master/snowstorm-min.js", function() {  });
        // 1. Define a color for the snow
        snowStorm.snowColor = '#fff';
        // 2. To optimize, define the max number of flakes that can be shown on screen at once
        snowStorm.flakesMaxActive = 500;
        // 3. Allow the snow to flicker in and out of the view
        snowStorm.useTwinkleEffect = true;
        // 4. Start the snowstorm!
        snowStorm.start();
    }

    var index = Math.floor(Math.random() * slogan.length);
    window.onload = function () { document.getElementById("slogan").innerHTML = slogan[index] };
</script>