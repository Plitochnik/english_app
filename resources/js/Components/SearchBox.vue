<template>
    <!-- search box -->

    <div id="search" class="searchBox">
        <svg viewBox="0 0 420 60" xmlns="http://www.w3.org/2000/svg">
            <rect class="bar"/>
            <g class="magnifier">
                <circle class="glass"/>
                <line class="handle" x1="32" y1="32" x2="44" y2="44"></line>
            </g>
            <g class="sparks">
                <circle class="spark"/>
                <circle class="spark"/>
                <circle class="spark"/>
            </g>
            <g class="burst pattern-one">
                <circle class="particle circle"/>
                <path class="particle triangle"/>
                <circle class="particle circle"/>
                <path class="particle plus"/>
                <rect class="particle rect"/>
                <path class="particle triangle"/>
            </g>
            <g class="burst pattern-two">
                <path class="particle plus"/>
                <circle class="particle circle"/>
                <path class="particle triangle"/>
                <rect class="particle rect"/>
                <circle class="particle circle"/>
                <path class="particle plus"/>
            </g>
            <g class="burst pattern-three">
                <circle class="particle circle"/>
                <rect class="particle rect"/>
                <path class="particle plus"/>
                <path class="particle triangle"/>
                <rect class="particle rect"/>
                <path class="particle plus"/>
            </g>
        </svg>

        <input
            :value="searchValue"
            @input="$emit('update:searchValue', $event.target.value)"
            :aria-label="ariaLabel"
            :placeholder="ariaLabel"
        />
    </div>
    <div id="results"></div>
</template>

<script>
export default {
    name: "SearchBox",

    props: {
        searchValue: {
            type: String,
            default: ''
        },
        ariaLabel: {
            type: String,
            default: 'Search'
        }
    }
}
</script>

<style scoped>
#search {
    display: grid;
    grid-area: search;
    grid-template:
		"search" 60px
		/ 420px;
    justify-content: center;
    align-content: center;
    justify-items: stretch;
    align-items: stretch;
    background: hsl(0, 0%, 99%);
    padding-top: 5vh;
}

#search input {
    display: block;
    grid-area: search;
    -webkit-appearance: none;
    appearance: none;
    width: 100%;
    height: 100%;
    background: none;
    padding: 0 30px 0 60px;
    border: none;
    border-radius: 100px;
    font: 24px/1 system-ui, sans-serif;
    outline-offset: -8px;
}

#search svg {
    grid-area: search;
    overflow: visible;
    color: hsl(213, 97%, 63%);
    fill: none;
    stroke: currentColor;
}

.burst {
    stroke-width: 3;
}

.burst :nth-child(2n) {
    color: #ff783e
}

.burst :nth-child(3n) {
    color: #ffab00
}

.burst :nth-child(4n) {
    color: #55e214
}

.burst :nth-child(5n) {
    color: #82d9f5
}

.circle {
    r: 6;
}

.rect {
    width: 10px;
    height: 10px;
}

.triangle {
    d: path("M0,-6 L7,6 L-7,6 Z");
    stroke-linejoin: round;
}

.plus {
    d: path("M0,-5 L0,5 M-5,0L 5,0");
    stroke-linecap: round;
}

.burst:nth-child(4) {
    transform: translate(30px, 100%) rotate(150deg);
}

.burst:nth-child(5) {
    transform: translate(50%, 0%) rotate(-20deg);
}

.burst:nth-child(6) {
    transform: translate(100%, 50%) rotate(75deg);
}

.burst * {
}

@keyframes particle-fade {
    0%, 100% {
        opacity: 0
    }
    5%, 80% {
        opacity: 1
    }
}

.burst :nth-child(1) {
    animation: particle-fade 600ms 0.55s both, particle-one-move 600ms 0.55s both;
}

.burst :nth-child(2) {
    animation: particle-fade 600ms 0.55s both, particle-two-move 600ms 0.55s both;
}

.burst :nth-child(3) {
    animation: particle-fade 600ms 0.55s both, particle-three-move 600ms 0.55s both;
}

.burst :nth-child(4) {
    animation: particle-fade 600ms 0.55s both, particle-four-move 600ms 0.55s both;
}

.burst :nth-child(5) {
    animation: particle-fade 600ms 0.55s both, particle-five-move 600ms 0.55s both;
}

.burst :nth-child(6) {
    animation: particle-fade 600ms 0.55s both, particle-six-move 600ms 0.55s both;
}

@keyframes particle-one-move {
    0% {
        transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001)
    }
    100% {
        transform: rotate(-20deg) translateX(8%) scale(0.5, 0.5)
    }
}

@keyframes particle-two-move {
    0% {
        transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001)
    }
    100% {
        transform: rotate(0deg) translateX(8%) scale(0.5, 0.5)
    }
}

@keyframes particle-three-move {
    0% {
        transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001)
    }
    100% {
        transform: rotate(20deg) translateX(8%) scale(0.5, 0.5)
    }
}

@keyframes particle-four-move {
    0% {
        transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001)
    }
    100% {
        transform: rotate(-35deg) translateX(12%)
    }
}

@keyframes particle-five-move {
    0% {
        transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001)
    }
    100% {
        transform: rotate(0deg) translateX(12%)
    }
}

@keyframes particle-six-move {
    0% {
        transform: rotate(0deg) translate(-5%) scale(0.0001, 0.0001)
    }
    100% {
        transform: rotate(35deg) translateX(12%)
    }
}

.bar {
    width: 100%;
    height: 100%;
    ry: 50%;
    stroke-width: 10;
    animation: bar-in 900ms 0.55s both;
}

@keyframes bar-in {
    0% {
        stroke-dasharray: 0 180 0 226 0 405 0 0
    }
    100% {
        stroke-dasharray: 0 0 181 0 227 0 405 0
    }
}

.magnifier {
    animation: magnifier-in 600ms 0.80s both;
    transform-box: fill-box;
}

@keyframes magnifier-in {
    0% {
        transform: translate(20px, 8px) rotate(-45deg) scale(0.01, 0.01);
    }
    50% {
        transform: translate(-4px, 8px) rotate(-45deg);
    }
    100% {
        transform: translate(0px, 0px) rotate(0deg);
    }
}

.magnifier .glass {
    cx: 27;
    cy: 27;
    r: 8;
    stroke-width: 3;
}

.magnifier .handle {
    x1: 32;
    y1: 32;
    x2: 44;
    y2: 44;
    stroke-width: 3;
}

#results {
    grid-area: results;
    background: hsl(0, 0%, 95%);
}
</style>
