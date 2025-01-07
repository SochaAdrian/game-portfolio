import {create} from 'zustand';

interface Resource {
    id: number;
    name: string;
    value: number;
    progress?: number;
    generation?: number;
    original_id: number;
}

interface ResourceState {
    resources: Resource[];
    updateResource: (id: number, newValue: number) => void;
    setResources: (resources: Resource[]) => void;
    incrementProgress: (resourceId: number) => void;
}

const useResourceStore = create<ResourceState>((set) => ({
    resources: [],

    updateResource: (id, newValue) =>
        set((state) => ({
            resources: state.resources.map((resource) =>
                resource.id === id || resource.original_id === id
                    ? {
                        ...resource,
                        value: newValue,
                        progress: resource.progress || 0,
                    }
                    : resource,
            ),
        })),

    setResources: (resources) => set(() => ({ resources })),

    incrementProgress: (resourceId: number) =>
        set((state) => ({
            resources: state.resources.map((resource) => {
                if (resource.id === resourceId) {
                    const newProgress = (resource.progress || 0) + 1;

                    return {
                        ...resource,
                        progress: newProgress >= 10 ? 0 : newProgress,
                    };
                }

                return resource;
            }),
        })),
}));

export default useResourceStore;
