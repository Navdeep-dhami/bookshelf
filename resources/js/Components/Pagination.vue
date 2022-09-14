<template>
    <nav aria-label="Page navigation example" v-if="links.length > 3">
        <ul class="pagination">
            <li class="page-item">
                <button class="page-link" aria-label="First" :value="modelValue" @click="$emit('update:modelValue', 1)"  ref="input">
                    <span aria-hidden="true">&laquo;</span></button></li>
            <template v-for="(pageNumber,index) in getLinks()" :key="index">
                <li class="page-item" :class="{ 'active': (currentPage == pageNumber) }">
                    <button class="page-link" :value="modelValue" @click="$emit('update:modelValue', pageNumber)"  ref="input" v-html="pageNumber"></button>
                </li>
            </template>
            <li class="page-item">
                <button class="page-link" aria-label="Last" :value="modelValue" @click="$emit('update:modelValue', lastPage)"  ref="input">
                    <span aria-hidden="true">&raquo;</span></button></li>
        </ul>
    </nav>
</template>
<script>
    import { Link } from "@inertiajs/inertia-vue3";
    export default {
        emits: ['update:modelValue'],
        data(){
            return {
                linksOnPage : 7
            };
        },
        props: {
            links : Array,
            modelValue : Number,
            currentPage : Number,
            lastPage : Number
        },
        components: {
            Link
        },
        methods: {
            getLinks: function(){
                let start = 1;
                let output = [];
                if(this.lastPage <= this.linksOnPage)
                {
                    start = 1;
                }
                else if(this.currentPage > (this.lastPage - Math.floor(this.linksOnPage/2)))
                {
                    start = this.lastPage - (this.linksOnPage - 1);
                }
                else if(this.currentPage > Math.floor(this.linksOnPage/2))
                {
                    start = this.currentPage - Math.floor(this.linksOnPage/2);
                }
                else
                {
                    start = 1;
                }
                for(let i = start; i < (start + this.linksOnPage); i++ )
                {
                    if(i > this.lastPage)
                    {
                        break;
                    }
                    output.push(i);
                }
                return output;
            },
        },
        mounted(){
            // console.log(this.links);
        }
    }
    /**
     * link can also have
     *  "total": 50,
        "per_page": 15,
        "current_page": 1,
        "last_page": 4,
        "path": "http://laravel.app",
        first_page_url
        last_page_url
     */
</script>
