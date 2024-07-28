<template>
    <div class="card-container">
        <div class="card" @click="goToLogin">Card 1</div>
        <div class="card" @click="goToLogin">Card 2</div>
        <div class="card" @click="goToLogin">Card 3</div>
    </div>
</template>

<script>
export default {
    methods: {
        goToLogin() {
            this.$inertia.visit('/login');
        }
    }
}
</script>

<style scoped>
.card-container {
    display: flex;
    justify-content: space-around;
    margin: 20px;
}
.card {
    width: 100px;
    height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f3f3f3;
    border: 1px solid #ddd;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
}
.card:hover {
    background-color: #e2e2e2;
}
</style>
