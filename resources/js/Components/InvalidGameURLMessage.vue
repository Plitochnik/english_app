<template>
    <div class="wrongUrl">
        <h1 class="wrongUrlTitle">Undefined link 😢</h1>
        <div class="wrongUrlDescription">
            Please check the link you got. Make sure you've copied the whole thing. <br>
            Alternatively use the QR code that an owner of the game or players in the waiting room can share with you
        </div>
    </div>
</template>
<script>
export default {
    name: "InvalidGameURL"
}
</script>

<style scoped>
.wrongUrl {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 600px;
    height: 250px;
    border-radius: 30px;
    padding: 10px;
    background: green;
}

.wrongUrlTitle {
    font-size: 40px;
    display: flex;
    justify-content: center;
}
.wrongUrlDescription {
    margin-top: 40px;
    align-items: center;
    justify-content: center;
    display: flex;
    text-align: center;
}
</style>
