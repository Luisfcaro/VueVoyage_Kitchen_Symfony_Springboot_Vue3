import { toRefs } from 'vue';

export const formData = (data) => {
    const plainData = {};
    
    const dataRefs = toRefs(data);
    for (const key in dataRefs) {
        plainData[key] = dataRefs[key].value;
    }

    return JSON.parse(JSON.stringify(plainData));
};