import {Flipper} from 'flip-toolkit'
/**
 * @property {HTMLElement} pagination
 * @property {HTMLElement} content
 * @property {HTMLFormElement} form
 */

export default class Filer {

    /**
     * @param {HTMLElement|null} element
     */
    constructor(element){
        if(element === null){
            return
        }
        this.pagination = element.querySelector('.js-filter-pagination')
        this.content = element.querySelector('.js-filter-content')
        this.form = element.querySelector('.js-filter-form')
        this.bindEvents()
    }

    bindEvents(){
        const aClickListener = e => {
            if (e.target.tagName === 'A') {
                e.preventDefault()
                this.loadUrl(e.target.getAttribute('href'))
            }
        }
        this.pagination.addEventListener('click', aClickListener)
        this.form.querySelectorAll('input').forEach(input => {
            input.addEventListener('change', this.loadForm.bind(this))
        })
    }

    async loadForm(){
        const data = new FormData(this.form)
        const url = new URL(this.form.getAttribute('action') || window.location.href)
        const params = new URLSearchParams()
        data.forEach((value, key) => {
            params.append(key, value)
        })
        return this.loadUrl(url.pathname + '?' + params.toString())
    }

    async loadUrl (url) {
        const ajaxUrl = url + '&ajax=1'
        const response = await fetch(ajaxUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        if(response.status >= 200 && response.status < 300){
            const data = await response.json()
            this.content.innerHTML = data.content
            this.flipContent(data.content)
            this.pagination.innerHTML = data.pagination
            history.replaceState({}, '', url)
        }else{
            console.error(response)
        }
    }

    /**
     * Remplace les éléments de la grille
     * @param {string} content
     */
    flipContent (content) {
        const flipper = new Flipper({
            element: this.content
        })
        this.content.forEach(c => {
            flipper.addFlipped({
                element,
                flipId: element.id
            })
        })
        flipper.recordBeforeUpdate()
        this.content.innerHTML = data.content
        this.content.forEach(c => {
            flipper.addFlipped({
                element,
                flipId: element.id,
                shouldFlip: false,
                onExit: (element, index, remove) => {
                    window.setTimeout(() => {
                        remove()
                    }, 2000)
                }

            })
        })
        flipper.update()
    }
}