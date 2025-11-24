import { Folder, MapPinned, Tag, LockKeyhole } from 'lucide-vue-next';
import { admin } from '@/routes-custom';
import type { NavItem } from '@/types';

const { dashboard, proyectos, categorias, accesos, ubicaciones } = admin;

export const allMainNavItems: NavItem[] = [
  {
    title: 'Dashboard',
    href: dashboard().url,
    icon: MapPinned,
  },
  {
    title: 'Proyectos',
    href: proyectos.index().url,
    icon: Folder,
    roles: ['admin'],
  },
  {
    title: 'Ubicaciones',
    href: ubicaciones().url,
    icon: MapPinned,
    roles: ['admin'],
  },
  {
    title: 'Categorías',
    href: categorias().url,
    icon: Tag,
    roles: ['admin'],
  },
  {
    title: 'Accesos',
    href: accesos().url,
    icon: LockKeyhole,
    roles: ['admin'],
  },
];
