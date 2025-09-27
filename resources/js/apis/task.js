import axios from './index';

export const getLatestBoard = async () => {
    return axios.get('/boards/latest');
}

export const addTask = async (boardId, task) => {
    return axios.post(`/${boardId}/tasks`, task);
}

export const getTaskById = async (boardId, taskId) => {
    return axios.get(`/${boardId}/tasks/${taskId}`);
}

export const updateTask = async (boardId, taskId, updatedTask) => {
    return axios.put(`/${boardId}/tasks/${taskId}`, updatedTask);
}
