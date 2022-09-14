<template>
  <Head title="Welcome" />

  <header class="container fixed-top position-relative">
    <div class="row">
      <div class="col-12">
        <div class="d-flex justify-content-end mb-3">
            <Link v-if="canAdd"
            :href="route('books.create')"
            class="ms-4 text-muted badge p-3 bg-warning text-decoration-none"
            >Add Book</Link>
            <Link
                v-if="canRegister"
                :href="route('register')"
                class="ms-4 text-muted badge bg-white p-3"
              >
                Register
              </Link>
              <Link v-if="canLogin" :href="route('login')" class="text-muted badge bg-white p-3 ms-4">
                Log in
              </Link>
            <button
              v-if="$page.props.auth.user"
              @click="logout" as="button"
              class="text-muted badge bg-white p-3 ms-4"
            >
              Log Out
            </button>
        </div>
      </div>
      <div class="col-12">
        <div class="input-group mb-3">
            <button class="btn btn-outline-secondary dropdown-toggle bg-white w-25 d-flex justify-content-around align-items-center p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">{{searchCategory}}</button>
            <ul class="dropdown-menu">
            <li><button class="dropdown-item" type="button" v-on:click="updateCategory('title')">title</button></li>
            <li><button class="dropdown-item" type="button" v-on:click="updateCategory('author')">Author</button></li>
            <li><button class="dropdown-item" type="button" v-on:click="updateCategory('publication')">Publication date</button></li>
            <li><button class="dropdown-item" type="button" v-on:click="updateCategory('isbn')">isbn</button></li>
            <li><button class="dropdown-item" type="button" v-on:click="updateCategory('genre')">genre</button></li>
            </ul>
            <breeze-input id="search" :type="searchInputType" v-model="searchInput" v-on:keyup.enter="inputSearch"/>
        </div>
      </div>
    </div>

</header>
<section>
    <div class="container">
        <div class="row" v-if="products.total > 0">
            <div class="col-12" v-for="(item,key) in products.data" :key="key">
            <ProductItem  :product="item" :canDeleteItem="canDelete" :canEditItem="canEdit" />
            </div>
            <pagination v-model="currentPage" class="mt-6" :links="products.links" :currentPage="products.current_page" :lastPage="products.last_page" />
        </div>
        <p v-else>nothing found Total result : {{products.total}}</p>
    </div>
</section>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import BreezeInput from '@/Components/Input.vue';
import ProductItem from '@/Components/ProductItem.vue';
import Pagination from '@/Components/Pagination.vue';
import axios from "axios";

export default {
  components: {
    Head,
    Link,
    BreezeInput,
    ProductItem,
    Pagination
  },
  data() {
    return {
      searchInput : '',
      searchInputType : 'text',
      searchCategory : 'title',
      products: {total : 0},
      currentPage: 1
    }
  },
  props: {
    canLogin: Boolean,
    canRegister: Boolean,
    canAdd: Boolean,
    canEdit: Boolean,
    canDelete: Boolean,
  },
  watch: {
    currentPage(prev,current)
    {
        if(prev != current)
        {
            this.fetchData();
        }
    }
  },
  methods: {
    updateCategory: function(text)
    {
        if(text == 'publication')
        {
            // input date
            this.searchInputType = 'date';
            this.searchInput = '';
        }
        else{
            // input string
            this.searchInputType = 'text';
            this.searchInput = '';
        }
        this.searchCategory = text;
    },
    inputSearch: function(){
        this.currentPage = 1;
        this.fetchData();
    },
    fetchData: function()
    {
        let url = this.route('books.index',
        {
            'query': this.searchInput,
            'category': this.searchCategory,
            'page': this.currentPage
        });
          axios.get(url).then((res) => {
            this.products = res.data;
            // console.log(res.data);
          });
    },
    logout() {
      this.$inertia.post(route("logout"));
    }
  },
  beforeMount(){
    this.fetchData();
  },
};
</script>
