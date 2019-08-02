<template>
    <div id="calculator">

        <div class="calculator-logs">
            <span v-for="log in logs">{{ log }}</span>
        </div>

        <input type="string" class="calculator-input" v-model="current">

        <div class="calculator-row">
            <div class="calculator-col">
                <button class="calculator-btn gray action" @click="clear()">C</button>
            </div>
            <div class="calculator-col">
                <button class="calculator-btn gray action" @click="del()">del</button>
            </div>
            <div class="calculator-col">
                <button class="calculator-btn gray action">+/-</button>
            </div>
            <div class="calculator-col">
                <button class="calculator-btn accent action">/</button>
            </div>
        </div>
        <div class="calculator-row">
            <div class="calculator-col">
                <button class="calculator-btn" @click="addExpresion(7)">7</button>
            </div>
            <div class="calculator-col">
                <button class="calculator-btn" @click="addExpresion(8)">8</button>
            </div>
            <div class="calculator-col">
                <button class="calculator-btn" @click="addExpresion(9)">9</button>
            </div>
            <div class="calculator-col">
                <button class="calculator-btn accent action">*</button>
            </div>
        </div>
        <div class="calculator-row">
            <div class="calculator-col">
                <button class="calculator-btn" @click="addExpresion(4)">4</button>
            </div>
            <div class="calculator-col">
                <button class="calculator-btn btn5" @click="addExpresion(5)">5</button>
            </div>
            <div class="calculator-col">
                <button class="calculator-btn" @click="addExpresion(6)">6</button>
            </div>
            <div class="calculator-col">
                <button class="calculator-btn accent action btn-minus" @click="operationClicked('-')">-</button>
            </div>
        </div>
        <div class="calculator-row">
            <div class="calculator-col">
                <button class="calculator-btn" @click="addExpresion(1)">1</button>
            </div>
            <div class="calculator-col">
                <button class="calculator-btn" @click="addExpresion(2)">2</button>
            </div>
            <div class="calculator-col">
                <button class="calculator-btn btn3" @click="addExpresion(3)">3</button>
            </div>
            <div class="calculator-col">
                <button class="calculator-btn accent action btn-plus" @click="operationClicked('+')">+</button>
            </div>
        </div>
        <div class="calculator-row">
            <div class="calculator-col wide">
                <button class="calculator-btn" @click="addExpresion(0)">0</button>
            </div>
            <div class="calculator-col">
                <button class="calculator-btn action" @click="dot()">.</button>
            </div>
            <div class="calculator-col">
                <button class="calculator-btn accent action btn-result" @click="equal()">=</button>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                previous: null,
                current: 0,
                operator: null,
                operatorClicked: false,
                logs: [],
                result: false
            }
        },
        methods: {
            clear() {
                this.current = '';
            },
            del() {
                this.current = this.current.slice(0, this.current.length-1);
            },
            blink() {
                const temp = this.current;
                this.current = '';
                setTimeout(() => {
                    this.current = temp;
            }, 300);
            },
            sign() {
                this.current = this.current.charAt(0) === '-' ?
                    this.current.slice(1) : `-${this.current}`;
            },

            addExpresion(number) {
                if (this.operatorClicked || this.result) {
                    this.current = '';
                    this.operatorClicked = false;
                }
                this.current = this.current == 0 ? '': this.current;
                this.current = `${this.current}${number}`;
            },
            dot() {
                if (this.current.indexOf('.') === -1) {
                    this.addExpresion('.');
                }
            },
            setPrevious() {
                this.previous = this.current;
                this.operatorClicked = true;
                this.blink();
            },
            operationClicked(op) {
                // if(this.previous) this.equal();
                // this.operator = (a, b) => a - b;
                this.operator = op;
                this.setPrevious();
            },
            equal() {

                const log = this.previous+''+this.operator+''+this.current;
                const current = this.current;
                const previous = this.previous;
                const operator = this.operator;
                switch(this.operator) {
                    case '+':
                        this.current = parseFloat(this.previous) + parseFloat(this.current);
                        break;
                    case '-':
                        this.current = parseFloat(this.previous) - parseFloat(this.current);
                        break;
                }
                this.logs.push(log+' = '+this.current);

                this.postCalculation(previous, current, operator);

                this.previous = null;
                this.result = true;

            },
            postCalculation(previous, current, operator) {
                axios.post('http://0.0.0.0:8080/api/calculation', {
                    first_operand: previous,
                    second_operand: current,
                    operator: operator
                })
                    .then(function (response) {
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            getLatestCalculations() {
                axios.get('http://0.0.0.0:8080/api/latest-calculations')
                    .then((response) => {
                    if(response.data.length){
                    response.data.reverse().forEach((d) => {
                        const log = d.first_operand+''+d.operator+''+d.second_operand;
                    this.logs.push(log+' = '+d.result);
                })
                }
                // currentObj.output = response.data;
            })
            .catch(function (error) {
                    console.log(error);
                });
            }

        },
        mounted() {
            this.getLatestCalculations();
        }
    }
</script>
