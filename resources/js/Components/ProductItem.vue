<template>
 <div v-if="isDeleted" class="d-flex p-3 shadow-sm bg-white mb-3">

    <div class=" col-3">
        <img :src="product.image" :alt="product.title" class="w-100">
    </div>
    <div class="d-flex flex-column col-7 ms-5">
        <h3 class="mt-0 font-weight-bold mb-2">{{product.title}}</h3>
        <p class="font-italic text-muted mb-0 small">{{product.description}}</p>
        <div class="d-flex mt-1">
            <div class="d-flex flex-column me-5">
                <p class="my-2 h5">Genre</p>
                <p class="my-2 h5">author</p>
                <p class="my-2 h5">isbn</p>
                <p class="my-2 h5">publisher</p>
                <p class="my-2 h5">published</p>
            </div>
            <div class="d-flex flex-column">
                <span class="my-2">{{product.genre.name}}</span>
                <span class="my-2">{{product.author.name}}</span>
                <span class="my-2">{{product.isbn}}</span>
                <span class="my-2">{{product.publisher.name}}</span>
                <span class="my-2">{{product.published}}</span>
            </div>
        </div>
        <div class="mt-3">
            <button v-if="canDeleteItem" type="button" @click="deleteItem" as="button" class="btn btn-outline-danger">Delete Item</button>

            <Link v-if="canEditItem"
            :href="route('books.edit',{'book':product})"
            class="ms-4 btn btn-outline-primary"
            >Edit Item</Link>
        </div>
    </div>
</div>
</template>

<script>
  import { defineComponent } from 'vue'
  import { Link } from "@inertiajs/inertia-vue3";

	export default defineComponent({
        props: ['product','canDeleteItem','canEditItem'],
        components: {
            Link
        },
        data() {
            return {
                isDeleted : true
            }
        },
        methods: {
        deleteItem: function(){
            let url = this.route("books.destroy",{'book':this.product});
            this.$inertia.delete(url);
            this.isDeleted = false;
        }
        }
	});
</script>
