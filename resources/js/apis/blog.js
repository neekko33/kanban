import axios from "./index";

export const getPosts = (page) => {
    return axios.get("/posts", {
        params: { page },
    });
};
