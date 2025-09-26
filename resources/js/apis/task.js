import axios from './index';

export const getLatestBoard = () => {
    return axios.get('/boards/latest');
}
