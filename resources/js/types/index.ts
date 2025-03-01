import { LucideIcon } from 'lucide-react';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    url: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

/** APICase is the case structure from the API. */
export type APICase = {
    /** Extra properties from custom cases */
    extra?: {
        // Case gold chance (0-1)
        gold_chance?: number;
        // Whether or not the case should not give StatTraks
        disable_stattraks?: boolean;
    };
    id: string;
    type: string | null;
    first_sale_date: string | null;
    name: string;
    description: string | null;
    image: string;
    contains: APIItem[];
    contains_rare: APIItem[];
};

/** ItemType is the item structure from the API. */
export type APIItem = {
    id: string;
    name: string;
    rarity: {
        id: string;
        name: string;
        color: string;
    };
    phase?: string | null;
    image: string;
};

/** IndexedDBItem is the item structure saved to IndexedDB. */
export type IndexedDBItem = {
    id: string;
    name: string;
    rarity: string;
    phase: string | null;
};

/** GradeType is the possible item rarities. */
export type ItemGrade = 'Consumer Grade' | 'Industrial Grade' | 'Mil-Spec Grade' | 'Restricted' | 'Classified' | 'Covert' | 'Rare Special Item';

/** CasePickerCase is the APICase data being passed to the case picker */
export type CasePickerCase = Pick<APICase, 'id' | 'name' | 'description' | 'image' | 'first_sale_date'>;

export type UnboxWithRelations = {
    id: number;
    case_id: string;
    item_id: string;
    is_stat_trak: boolean;
    updated_at: string;
    created_at: string;
    case: {
        id: string;
        type: string;
        name: string;
        description: string;
        image: string;
        created_at: string;
        updated_at: string;
    };
    item: {
        id: string;
        name: string;
        description: string;
        image: string;
        rarity: string;
        phase: string | null;
        created_at: string;
        updated_at: string;
    };
};
