import axios from "./index";

export const getPosts = (page) => {
    return axios.get("/posts", {
        params: { page },
    });
};

export const getTags = () => {
    return axios.get("/tags");
}

export const getCategories = () => {
    return axios.get("/categories");
}
