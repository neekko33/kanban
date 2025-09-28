import axios from "./index";

export const getLatestBoard = async () => {
    return axios.get("/boards/latest");
};

export const addBoard = async () => {
    return axios.post("/boards");
};

export const updateBoard = async (boardId, updatedBoard) => {
    return axios.put(`/boards/${boardId}`, updatedBoard);
};

export const addTask = async (boardId, task) => {
    return axios.post(`/${boardId}/tasks`, task);
};

export const getTaskById = async (boardId, taskId) => {
    return axios.get(`/${boardId}/tasks/${taskId}`);
};

export const updateTask = async (boardId, taskId, updatedTask) => {
    return axios.put(`/${boardId}/tasks/${taskId}`, updatedTask);
};
