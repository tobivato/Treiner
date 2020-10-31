<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "BlogPosting",
        "headline": "{{$blog->title}}",
        "wordCount": {{str_word_count($blog->content)}},
        "author": "{{$blog->coach ? $blog->coach->user->name : 'Treiner'}}",
        "publisher": {
            "@type": "Organization",
            "name": "Treiner",
            "description": "Treiner is a platfom used to find qualified and vetted professional soccer coaches and service providers",
            "logo": {
                "@type": "ImageObject",
                "url": "{{asset('android-chrome-512x512.png')}}"
            },
            "legalName": "Dynamic Sports Solutions Pty Ltd",
            "url": "{{route('welcome')}}",
            "sameAs": [
              "https://www.facebook.com/treiner.co",
              "https://twitter.com/treinerco",
              "https://www.instagram.com/treiner.co",
              "https://www.linkedin.com/company/treiner"
            ]
        },
        "dateModified": "{{$blog->updated_at->format('c')}}",
        "datePublished": "{{$blog->created_at->format('c')}}",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "{{route('blogs.show', $blog)}}"
         },
        "image": [
            "{{Cloudder::secureShow($blog->image_id, ['width' => 696, 'height' => 696])}}",
            "{{Cloudder::secureShow($blog->image_id, ['width' => 1600, 'height' => 1200])}}",
            "{{Cloudder::secureShow($blog->image_id, ['width' => 1600, 'height' => 900])}}"
        ]
    }
</script>