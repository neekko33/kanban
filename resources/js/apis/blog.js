import axios from "./index";

export const getPosts = (page, pageSize) => {
    return axios.get("/posts", {
        params: { page, pageSize},
    });
};

export const getTags = (page, pageSize) => {
    return axios.get("/tags", {
        params: { page, pageSize },
    });
}

export const updateTag = (id, data) => {
    return axios.put(`/tags/${id}`, data);
}

export const addTag = (data) => {
    return axios.post("/tags", data);
}

export const deleteTag = (id) => {
    return axios.delete(`/tags/${id}`);
}

export const getCategories = (page, pageSize) => {
    return axios.get("/categories", {
        params: { page, pageSize },
    });
}

export const updateCategory = (id, data) => {
    return axios.put(`/categories/${id}`, data);
}

export const addCategory = (data) => {
    return axios.post("/categories", data);
}

export const deleteCategory = (id) => {
    return axios.delete(`/categories/${id}`);
}

export const addPost = (data) => {
    return axios.post("/posts", data);
}

export const getPost = (id) => {
    return axios.get(`/posts/${id}`);
}

export const updatePost = (id, data) => {
    return axios.put(`/posts/${id}`, data);
}

export const deletePost = (id) => {
    return axios.delete(`/posts/${id}`);
}