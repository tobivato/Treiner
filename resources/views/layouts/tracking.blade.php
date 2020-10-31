<script>
    ! function () {
        var analytics = window.analytics = window.analytics || [];
        if (!analytics.initialize)
            if (analytics.invoked) window.console && console.error && console.error("Segment snippet included twice.");
            else {
                analytics.invoked = !0;
                analytics.methods = ["trackSubmit", "trackClick", "trackLink", "trackForm", "pageview", "identify", "reset", "group", "track", "ready", "alias", "debug", "page", "once", "off", "on"];
                analytics.factory = function (t) {
                    return function () {
                        var e = Array.prototype.slice.call(arguments);
                        e.unshift(t);
                        analytics.push(e);
                        return analytics
                    }
                };
                for (var t = 0; t < analytics.methods.length; t++) {
                    var e = analytics.methods[t];
                    analytics[e] = analytics.factory(e)
                }
                analytics.load = function (t, e) {
                    var n = document.createElement("script");
                    n.type = "text/javascript";
                    n.async = !0;
                    n.src = "https://cdn.segment.com/analytics.js/v1/" + t + "/analytics.min.js";
                    var a = document.getElementsByTagName("script")[0];
                    a.parentNode.insertBefore(n, a);
                    analytics._loadOptions = e
                };
                analytics.SNIPPET_VERSION = "4.1.0";
                analytics.load("O3bVBWkdUK72eLJ6Piw5g7A6e6W26pVE");
                analytics.page();
            }
    }();
</script>

<script>
    !function(w,d){if(!w.rdt){var p=w.rdt=function(){p.sendEvent?p.sendEvent.apply(p,arguments):p.callQueue.push(arguments)};p.callQueue=[];var t=d.createElement("script");t.src="https://www.redditstatic.com/ads/pixel.js",t.async=!0;var s=d.getElementsByTagName("script")[0];s.parentNode.insertBefore(t,s)}}(window,document);rdt('init','t2_67o5oo7c');rdt('track', 'PageVisit');
</script>