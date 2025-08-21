env = 'dev'
if (env === 'dev') {
    url = 'http://localhost:8080/?rest_route=/wp/v2/posts'
} else {
    url = '/wp-json/wp/v2/posts'
}

fetch(url)
    .then(resp => resp.json())
    .then(posts => {
        sp = document.querySelector('#story-slider .slide-items')
        posts.forEach(post => {
            s = document.createElement('div')
            s.className = 'story'
            s.innerHTML = `<div class="content">
                        <h4 class="title">${post['title']['rendered']}</h4>
                        <p>${post['excerpt']['rendered']}</p>
                    </div>
                    <div class="background">
                        <div class="gradient"></div>
                        <div class="image"><img src="${post['fimg_url']}"/></div>
                    </div>`
            sp.append(s)
        })
    })
    .then(() => {
        new SlideStories('slide');
    })

class SlideStories {
    constructor(id) {
        this.slide = document.querySelector(`[data-slide="${id}"]`);
        this.active = 0;
        this.init();
    }

    activeSlide(index) {
        this.active = index;
        this.items.forEach((item) => item.classList.remove('active'));
        this.items[index].classList.add('active');
        this.thumbItems.forEach((item) => item.classList.remove('active'));
        this.thumbItems[index].classList.add('active');
        this.autoSlide();
    }

    prev() {
        if (this.active > 0) {
            this.activeSlide(this.active - 1);
        } else {
            this.activeSlide(this.items.length - 1);
        }
    }

    next() {
        if (this.active < this.items.length - 1) {
            this.activeSlide(this.active + 1);
        } else {
            this.activeSlide(0);
        }
    }

    addNavigation() {
        const nextBtn = this.slide.querySelector('.slide-next');
        const prevBtn = this.slide.querySelector('.slide-prev');
        nextBtn.addEventListener('click', this.next);
        prevBtn.addEventListener('click', this.prev);
    }

    addThumbItems() {
        this.items.forEach(() => (this.thumb.innerHTML += `<span></span>`));
        this.thumbItems = Array.from(this.thumb.children);
    }

    autoSlide() {
        clearTimeout(this.timeout);
        this.timeout = setTimeout(this.next, 5000);
    }

    init() {
        this.next = this.next.bind(this);
        this.prev = this.prev.bind(this);
        this.items = this.slide.querySelectorAll('.slide-items > *');
        this.thumb = this.slide.querySelector('.slide-thumb');
        this.addThumbItems();
        this.activeSlide(0);
        this.addNavigation();
    }
}


document.querySelectorAll('.party-item').forEach(story => {
    story.addEventListener('click', () => {
        document.querySelector('section.story-container').classList.toggle('active')
    })
})

document.querySelector('section.story-container .backdrop').addEventListener('click', () => {
    document.querySelector('section.story-container').classList.toggle('active')
})

