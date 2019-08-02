jest.mock('axios', () => ({
    post: () => Promise.resolve({ data: {} }),
    get: () => Promise.resolve({ data: [
        {
            "id": 2,
            "first_operand": 9,
            "second_operand": 9,
            "operator": "-",
            "result": 0,
            "created_at": "2019-07-31 23:17:42",
            "updated_at": "2019-07-31 23:17:42"
        },
        {
            "id": 1,
            "first_operand": -9,
            "second_operand": 9,
            "operator": "-",
            "result": -18,
            "created_at": "2019-07-31 23:16:12",
            "updated_at": "2019-07-31 23:16:12"
        }
    ] })
}))
import { shallowMount } from '@vue/test-utils';
import Calculator from '@/components/CalculatorComponent.vue';

describe('Calculator.vue', () => {
    it('Check Addition', () => {

        const wrapper = shallowMount(Calculator)
        wrapper.find('button.btn3').trigger('click');
        wrapper.find('button.btn-plus').trigger('click');
        wrapper.find('button.btn5').trigger('click');
        wrapper.find('button.btn-result').trigger('click');
        expect(wrapper.vm.current).toEqual(8);
    });

    it('Check Subtraction', () => {
        const wrapper = shallowMount(Calculator);
        wrapper.find('button.btn5').trigger('click');
        wrapper.find('button.btn-minus').trigger('click');
        wrapper.find('button.btn3').trigger('click');
        wrapper.find('button.btn-result').trigger('click');
        expect(wrapper.vm.current).toEqual(2);
    });

    it('Check Continue calculation', () => {
        const wrapper = shallowMount(Calculator);
        wrapper.find('button.btn5').trigger('click');
        wrapper.find('button.btn-minus').trigger('click');
        wrapper.find('button.btn3').trigger('click');
        wrapper.find('button.btn-result').trigger('click');
        wrapper.find('button.btn-plus').trigger('click');
        wrapper.find('button.btn5').trigger('click');
        wrapper.find('button.btn-result').trigger('click');
        expect(wrapper.vm.current).toEqual(7);
    });

    it('Check Multiple calculation', () => {
        const wrapper = shallowMount(Calculator);
        wrapper.find('button.btn5').trigger('click');
        wrapper.find('button.btn-minus').trigger('click');
        wrapper.find('button.btn3').trigger('click');
        wrapper.find('button.btn-result').trigger('click');
        wrapper.find('button.btn5').trigger('click');
        wrapper.find('button.btn-plus').trigger('click');
        wrapper.find('button.btn5').trigger('click');
        wrapper.find('button.btn-result').trigger('click');
        expect(wrapper.vm.current).toEqual(10);
    });
})
