<template v-for="produk in produks" v-bind:value="produk.id">
    <table>
        <tr>
            <td>
                Produk
            </td>
            <td>
            <template>
                    <select name="produk_id" v-model="selected" id="e2">
                        <option value="{{produk.id}}">{{ produk.name }}</option>
                    </select>
            </template>
            </td>
    </table>
</template>
<script>

export default
{
    data(){
        return {
            produks: [],
            subcategori: []
        }
    },
    mounted(){
        this.loadData();
    },
    methods:{
        loadData() {
            // fetch data dari api menggunakan axios
            axios.get("http://localhost:8000/api/produk").then(response => {
                // mengirim data hasil fetch ke varibale array persons
                this.produk = response.data;
            });
        }
    }
}
</script>
