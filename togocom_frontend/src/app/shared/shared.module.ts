import { CommonModule } from "@angular/common";
import { RouterModule } from "@angular/router";
import { NgModule } from "@angular/core";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { NgbModule } from "@ng-bootstrap/ng-bootstrap";
// import { DragulaModule } from "ng2-dragula";
import { TranslateModule } from "@ngx-translate/core";
// Components
import { FeatherIconsComponent } from "./components/feather-icons/feather-icons.component";
import { FooterComponent } from "./components/footer/footer.component";
import { HeaderComponent } from "./components/header/header.component";
import { ContentComponent } from "./components/layout/content/content.component";
import { FullComponent } from "./components/layout/full/full.component";
import { LoaderComponent } from "./components/loader/loader.component";
import { SidebarComponent } from "./components/sidebar/sidebar.component";
import { TapToTopComponent } from "./components/tap-to-top/tap-to-top.component";
// Header Elements Components
import { SearchComponent } from "./components/header/elements/search/search.component";
import { MegaMenuComponent } from "./components/header/elements/mega-menu/mega-menu.component";
import { LanguagesComponent } from "./components/header/elements/languages/languages.component";
import { NotificationComponent } from "./components/header/elements/notification/notification.component";
import { MessageBoxComponent } from "./components/header/elements/message-box/message-box.component";
import { MyAccountComponent } from "./components/header/elements/my-account/my-account.component";

// Services
import { LayoutService } from "./services/layout.service";
import { NavService } from "./services/nav.service";
import { DecimalPipe } from "@angular/common";
import { SvgIconComponent } from "./components/svg-icon/svg-icon.component";
import { SwiperModule } from "swiper/angular";
import { SwiperComponent } from './components/header/elements/swiper/swiper.component';
import { BreadcrumbComponent } from "./components/breadcrumb/breadcrumb.component";
import { BookmarkComponent } from "./components/header/elements/bookmark/bookmark.component";

@NgModule({
  declarations: [
    HeaderComponent,
    FooterComponent,
    SidebarComponent,
    ContentComponent,
    BreadcrumbComponent,
    FeatherIconsComponent,
    FullComponent,
    LoaderComponent,
    TapToTopComponent,
    SearchComponent,
    MegaMenuComponent,
    BookmarkComponent,
    LanguagesComponent,
    NotificationComponent,
    MessageBoxComponent,
    MyAccountComponent,
    SvgIconComponent,
    SwiperComponent,
  ],
  imports: [
    CommonModule, 
    RouterModule,
    FormsModule,
    ReactiveFormsModule,
    NgbModule,
    // DragulaModule.forRoot(),
    TranslateModule.forRoot(),
    SwiperModule],
  providers: [NavService, LayoutService, DecimalPipe],
  exports: [NgbModule, FormsModule, ReactiveFormsModule,
    TranslateModule,
    LoaderComponent, FeatherIconsComponent,BreadcrumbComponent, TapToTopComponent, SvgIconComponent, SwiperModule],
})
export class SharedModule {}
