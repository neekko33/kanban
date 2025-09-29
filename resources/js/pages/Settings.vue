<script setup>
import { useAuthStore } from "@/store/store";
import { inject, ref } from "vue";
import { updateProfile, updatePassword } from "@/apis/settings";
import { useRouter } from "vue-router";

const { user, getUser, logout } = useAuthStore();

const profile = ref({
    username: user.name,
    email: user.email,
    bio: user.bio || "",
    avatar_url: user.avatar_url || "",
});

const passwordForm = ref({
    currentPassword: "",
    newPassword: "",
    confirmPassword: "",
});

const handleUpdateProfile = async () => {
    const { data } = await updateProfile(profile.value);
    setAlert("success", "Profile updated successfully");
    profile.value = {
        username: data.name,
        email: data.email,
        bio: data.bio || "",
        avatar_url: data.avatar_url || "",
    }
    await getUser(); // 更新用户信息
};

const setAlert = inject("setAlert");
const router = useRouter();
const handleUpdatePassword = async () => {
    if (passwordForm.value.newPassword !== passwordForm.value.confirmPassword) {
        setAlert("error", "New password and confirm password do not match");
        return;
    }

    const { data } = await updatePassword({
        current_password: passwordForm.value.currentPassword,
        new_password: passwordForm.value.newPassword,
    });

    logout();
};
</script>
<template>
    <div class="p-4 space-y-4">
        <h1 class="text-3xl font-bold">Settings</h1>
        <div class="flex flex-col gap-8 w-full items-center">
            <fieldset
                class="fieldset bg-base-200 border-base-300 rounded-box border p-4 w-2xl"
            >
                <legend class="fieldset-legend">User Info</legend>

                <label class="label">Username</label>
                <input
                    v-model="profile.username"
                    type="text"
                    class="input w-full"
                    placeholder="Username"
                />

                <label class="label">Email</label>
                <input
                    v-model="profile.email"
                    type="text"
                    class="input w-full"
                    placeholder="Email"
                />

                <label class="label">Bio</label>
                <input
                    v-model="profile.bio"
                    type="text"
                    class="input w-full"
                    placeholder="Bio"
                />

                <label class="label">Avatar Url</label>
                <input
                    v-model="profile.avatar_url"
                    type="text"
                    class="input w-full"
                    placeholder="Avatar Url"
                />

                <button class="btn btn-primary mt-4" @click="handleUpdateProfile">Update Profile</button>
            </fieldset>
            <fieldset
                class="fieldset bg-base-200 border-base-300 rounded-box border p-4 w-2xl"
            >
                <legend class="fieldset-legend">Change Password</legend>

                <label class="label">Current Password</label>
                <input
                    v-model="passwordForm.currentPassword"
                    type="password"
                    class="input w-full"
                    placeholder="Current Password"
                />

                <label class="label">New Password</label>
                <input
                    v-model="passwordForm.newPassword"
                    type="password"
                    class="input w-full"
                    placeholder="New Password"
                />

                <label class="label">Confirm Password</label>
                <input
                    v-model="passwordForm.confirmPassword"
                    type="password"
                    class="input w-full"
                    placeholder="Confirm Password"
                />
                <button class="btn btn-primary mt-4" @click="handleUpdatePassword">Update Password</button>
            </fieldset>
        </div>
    </div>
</template>
