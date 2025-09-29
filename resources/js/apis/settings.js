import axios from './index';

export const updateProfile = (profile) => {
    return axios.put('/settings/profile', profile);
}

export const updatePassword = (passwordData) => {
    return axios.put('/settings/password', passwordData);
}